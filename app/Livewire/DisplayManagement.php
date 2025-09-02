<?php

namespace App\Livewire;

use App\Models\Display;
use App\Models\Template;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class DisplayManagement extends Component
{
    use WithPagination;

    public $search = '';

    public $statusFilter = 'all';

    public $floorFilter = 'all';

    public $viewMode = 'table';

    // Add Display Form Properties
    public $showAddModal = false;

    public $editingDisplay = null;

    public $activeTab = 'edit'; // 'edit' or 'actions'

    public $name = '';

    public $make = '';

    public $model = '';

    public $ip_address = '';

    public $mac_address = '';

    public $os = '';

    public $version = '';

    public $firmware_version = '';

    public $location = '';

    public $floor = '';

    public $room = '';

    public $template_id = '';

    // Display Control Properties
    public $volume = 50;

    public $brightness = 100;

    public $powerAction = '';

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'floor' => 'nullable|string|max:255',
            'room' => 'nullable|string|max:255',
            'template_id' => 'nullable|exists:templates,id',
        ];

        // Only validate these fields when adding a new display
        if (! $this->editingDisplay) {
            $rules = array_merge($rules, [
                'make' => 'nullable|string|max:255',
                'model' => 'nullable|string|max:255',
                'ip_address' => 'nullable|ip',
                'mac_address' => 'nullable|string|max:255',
                'os' => 'nullable|string|max:255',
                'version' => 'nullable|string|max:255',
                'firmware_version' => 'nullable|string|max:255',
            ]);
        }

        return $rules;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedFloorFilter()
    {
        $this->resetPage();
    }

    #[Computed]
    public function displays()
    {
        return Display::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('make', 'like', '%'.$this->search.'%')
                        ->orWhere('model', 'like', '%'.$this->search.'%')
                        ->orWhere('ip_address', 'like', '%'.$this->search.'%')
                        ->orWhere('location', 'like', '%'.$this->search.'%')
                        ->orWhere('room', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->floorFilter !== 'all', function ($query) {
                $query->where('floor', $this->floorFilter);
            })
            ->with('template')
            ->orderBy('name')
            ->paginate(10);
    }

    #[Computed]
    public function stats()
    {
        $total = Display::count();
        $online = Display::where('online', true)->count();
        $offline = Display::where('online', false)->count();
        $poweredOff = Display::where('status', 'powered_off')->count();

        return [
            'total' => $total,
            'online' => $online,
            'offline' => $offline,
            'poweredOff' => $poweredOff,
        ];
    }

    #[Computed]
    public function floors()
    {
        return Display::distinct()->pluck('floor')->filter()->values();
    }

    #[Computed]
    public function templates()
    {
        return Template::orderBy('name')->get();
    }

    public function refreshAll()
    {
        // Refresh the component to get latest data
        $this->dispatch('$refresh');
        $this->dispatch('notify', ['message' => 'Display status refreshed!', 'type' => 'success']);
    }

    public function checkDisplayStatus()
    {
        // Manually trigger the display status check command
        try {
            \Artisan::call('displays:check-status', ['--timeout' => 60]);
            $output = \Artisan::output();

            $this->dispatch('$refresh');
            $this->dispatch('notify', [
                'message' => 'Display status check completed! '.trim($output),
                'type' => 'success',
            ]);
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'message' => 'Error checking display status: '.$e->getMessage(),
                'type' => 'error',
            ]);
        }
    }

    public function toggleDisplayStatus(Display $display)
    {
        // Toggle between online/offline for testing purposes
        $newStatus = $display->status === 'online' ? 'offline' : 'online';
        $display->update([
            'status' => $newStatus,
            'online' => $newStatus === 'online',
            'last_seen_at' => $newStatus === 'online' ? now() : $display->last_seen_at,
        ]);

        $this->dispatch('notify', [
            'message' => "Display {$display->name} is now {$newStatus}!",
            'type' => 'success',
        ]);
    }

    public function showAddModal()
    {
        $this->showAddModal = true;
        $this->resetForm();
    }

    public function hideAddModal()
    {
        $this->showAddModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'name', 'make', 'model', 'ip_address', 'mac_address',
            'os', 'version', 'firmware_version', 'location',
            'floor', 'room', 'template_id', 'volume', 'brightness', 'powerAction',
        ]);
        $this->editingDisplay = null;
        $this->activeTab = 'edit';
    }

    public function saveDisplay()
    {
        $this->validate();

        try {
            if ($this->editingDisplay) {
                // Only update editable fields in edit mode
                $editableData = [
                    'name' => $this->name,
                    'location' => $this->location,
                    'floor' => $this->floor,
                    'room' => $this->room,
                    'template_id' => $this->template_id ?: null,
                ];

                $this->editingDisplay->update($editableData);
                $this->dispatch('notify', ['message' => 'Display updated successfully!', 'type' => 'success']);
            } else {
                // All fields for new display
                $data = [
                    'name' => $this->name,
                    'make' => $this->make,
                    'model' => $this->model,
                    'ip_address' => $this->ip_address,
                    'mac_address' => $this->mac_address,
                    'os' => $this->os,
                    'version' => $this->version,
                    'firmware_version' => $this->firmware_version,
                    'location' => $this->location,
                    'floor' => $this->floor,
                    'room' => $this->room,
                    'template_id' => $this->template_id ?: null,
                    'status' => 'offline',
                    'online' => false,
                ];

                Display::create($data);
                $this->dispatch('notify', ['message' => 'Display added successfully!', 'type' => 'success']);
            }

            $this->hideAddModal();
            $this->resetPage();
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'Error saving display: '.$e->getMessage(), 'type' => 'error']);
        }
    }

    public function editDisplay(Display $display)
    {
        $this->editingDisplay = $display;
        // Only populate editable fields
        $this->name = $display->name;
        $this->location = $display->location;
        $this->floor = $display->floor;
        $this->room = $display->room;
        $this->template_id = $display->template_id;
        // Keep read-only fields for display purposes
        $this->make = $display->make;
        $this->model = $display->model;
        $this->ip_address = $display->ip_address;
        $this->mac_address = $display->mac_address;
        $this->os = $display->os;
        $this->version = $display->version;
        $this->firmware_version = $display->firmware_version;
        // Set default values for control actions
        $this->volume = 50;
        $this->brightness = 100;
        $this->powerAction = '';
        $this->activeTab = 'edit';
        $this->showAddModal = true;
    }

    public function deleteDisplay(Display $display)
    {
        $display->delete();
        $this->dispatch('notify', ['message' => 'Display deleted successfully!', 'type' => 'success']);
        $this->resetPage();
    }

    public function setVolume(Display $display)
    {
        // In a real application, this would send a command to the display
        $this->dispatch('notify', [
            'message' => "Volume set to {$this->volume}% for {$display->name}",
            'type' => 'success',
        ]);
    }

    public function setBrightness(Display $display)
    {
        // In a real application, this would send a command to the display
        $this->dispatch('notify', [
            'message' => "Brightness set to {$this->brightness}% for {$display->name}",
            'type' => 'success',
        ]);
    }

    public function powerControl(Display $display)
    {
        switch ($this->powerAction) {
            case 'power_on':
                $display->update(['status' => 'online', 'online' => true, 'last_seen_at' => now()]);
                $message = "Powering on {$display->name}";
                break;
            case 'power_off':
                $display->update(['status' => 'powered_off', 'online' => false]);
                $message = "Powering off {$display->name}";
                break;
            case 'restart':
                $display->update(['status' => 'offline', 'online' => false]);
                $message = "Restarting {$display->name}";
                break;
            default:
                $message = 'Invalid power action';
        }

        $this->dispatch('notify', ['message' => $message, 'type' => 'success']);
        $this->powerAction = '';
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.display-management');
    }
}
