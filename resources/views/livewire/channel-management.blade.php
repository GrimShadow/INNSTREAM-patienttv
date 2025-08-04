<?php

use App\Models\IptvChannel;
use Livewire\WithFileUploads;
use function Livewire\Volt\{state, with, usesFileUploads, rules, layout, title};

usesFileUploads();
layout('components.layouts.app');
title(__('Channel Management'));

// Component state
state([
    'viewMode' => 'table',
    'editingChannel' => null,
    'loadingChannel' => false,
    'form' => [
        'channel_number' => '',
        'channel_name' => '',
        'channel_logo' => null,
        'protocol' => '',
        'stream_address' => '',
        'username' => '',
        'password' => '',
        'head_end_assignment' => '',
        'status' => 'active',
    ]
]);

// Validation rules
rules([
    'form.channel_number' => 'nullable|integer|unique:iptv_channels,channel_number',
    'form.channel_name' => 'required|string|max:255',
    'form.channel_logo' => 'nullable|file|mimes:png,jpg,jpeg,gif|max:2048',
    'form.protocol' => 'required|in:http,https,rtmp,rtsp,udp,hls,dash',
    'form.stream_address' => 'required|string',
    'form.username' => 'nullable|string|max:255',
    'form.password' => 'nullable|string|max:255',
    'form.head_end_assignment' => 'nullable|string|max:255',
    'form.status' => 'required|in:active,inactive',
]);

// Provide data to view
with(fn () => [
    'channels' => IptvChannel::orderBy('channel_number')->get(),
    'headEnds' => [
        ['name' => 'Head-End A', 'location' => 'New York, NY', 'channels' => 85, 'status' => 'Online', 'ip' => '10.0.1.100'],
        ['name' => 'Head-End B', 'location' => 'Los Angeles, CA', 'channels' => 92, 'status' => 'Online', 'ip' => '10.0.2.100'],
        ['name' => 'Head-End C', 'location' => 'Chicago, IL', 'channels' => 67, 'status' => 'Maintenance', 'ip' => '10.0.3.100'],
        ['name' => 'Head-End D', 'location' => 'Miami, FL', 'channels' => 54, 'status' => 'Online', 'ip' => '10.0.4.100'],
        ['name' => 'Head-End E', 'location' => 'Dallas, TX', 'channels' => 73, 'status' => 'Offline', 'ip' => '10.0.5.100'],
        ['name' => 'Head-End F', 'location' => 'Seattle, WA', 'channels' => 89, 'status' => 'Online', 'ip' => '10.0.6.100'],
    ]
]);

// Actions
$openEditModal = function ($channelId) {
    $this->loadingChannel = true;
    $this->resetForm(); // Clear any previous data first
    
    $channel = IptvChannel::findOrFail($channelId);
    $this->editingChannel = $channel;
    $this->form = [
        'channel_number' => $channel->channel_number,
        'channel_name' => $channel->channel_name,
        'channel_logo' => null,
        'protocol' => $channel->protocol,
        'stream_address' => $channel->stream_address,
        'username' => $channel->username,
        'password' => $channel->password,
        'head_end_assignment' => $channel->head_end_assignment,
        'status' => $channel->status,
    ];
    $this->loadingChannel = false;
};

$resetForm = function () {
    $this->form = [
        'channel_number' => '',
        'channel_name' => '',
        'channel_logo' => null,
        'protocol' => '',
        'stream_address' => '',
        'username' => '',
        'password' => '',
        'head_end_assignment' => '',
        'status' => 'active',
    ];
    $this->editingChannel = null;
    $this->loadingChannel = false;
    $this->resetValidation();
};

$closeEditModal = function () {
    $this->resetForm();
};

$save = function () {
    $this->validate();

    $data = $this->form;
    
    // Handle file upload
    if ($this->form['channel_logo']) {
        $data['channel_logo'] = $this->form['channel_logo']->store('channel-logos', 'public');
    } else {
        unset($data['channel_logo']);
    }

    if ($this->editingChannel) {
        // Update existing channel
        if (!isset($data['channel_logo']) && $this->editingChannel->channel_logo) {
            $data['channel_logo'] = $this->editingChannel->channel_logo;
        }
        
        $this->editingChannel->update($data);
        session()->flash('success', "Channel '{$this->editingChannel->channel_name}' updated successfully!");
        $this->resetForm();
        $this->dispatch('modal-close', name: 'edit-channel-modal');
    } else {
        // Create new channel
        IptvChannel::create($data);
        session()->flash('success', "Channel '{$data['channel_name']}' created successfully!");
        $this->resetForm();
        $this->dispatch('modal-close', name: 'add-channel-modal');
    }
};

$delete = function ($channelId) {
    $channel = IptvChannel::findOrFail($channelId);
    $channelName = $channel->channel_name;
    $channel->delete();
    session()->flash('success', "Channel '{$channelName}' deleted successfully!");
    $this->resetForm();
    $this->dispatch('modal-close', name: 'edit-channel-modal');
};

?>

<div>
    <div class="flex h-full w-full flex-1 flex-col gap-6" x-data="{ viewMode: @entangle('viewMode') }">
    
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="rounded-lg bg-green-50 border border-green-200 p-4 dark:bg-green-900/20 dark:border-green-700" x-data="{ show: true }" x-show="show" x-transition>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-green-600 dark:text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm font-medium text-green-800 dark:text-green-300">
                            {{ session('success') }}
                        </span>
                    </div>
                    <button @click="show = false" class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

    @if($errors->any())
        <div class="rounded-lg bg-red-50 border border-red-200 p-4 dark:bg-red-900/20 dark:border-red-700" x-data="{ show: true }" x-show="show" x-transition>
                <div class="flex items-start justify-between">
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-red-600 dark:text-red-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <span class="text-sm font-medium text-red-800 dark:text-red-300 block mb-2">
                                {{ __('There were some errors with your submission:') }}
                            </span>
                            <ul class="text-sm text-red-700 dark:text-red-300 list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button @click="show = false" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

    <!-- Page Header -->
    <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <button class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm transition-colors" wire:click="$refresh">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    {{ __('Refresh All') }}
                </button>
                <flux:modal.trigger name="add-channel-modal">
                    <flux:button variant="primary" icon="plus" wire:click="resetForm">
                        {{ __('Add Channel') }}
                    </flux:button>
                </flux:modal.trigger>
            </div>
        </div>

        <!-- Header Stats -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-4">
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Total Channels') }}</p>
                        <p class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{ $channels->count() }}</p>
                    </div>
                    <svg class="h-5 w-5 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m0 0V2a1 1 0 011-1h2a1 1 0 011 1v18a1 1 0 01-1 1H4a1 1 0 01-1-1V2a1 1 0 011-1h2a1 1 0 011 1v2m0 0h10"/>
                    </svg>
                </div>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Active Channels') }}</p>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $channels->where('status', 'active')->count() }}</p>
                    </div>
                    <div class="h-2 w-2 rounded-full bg-green-500"></div>
                </div>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Linked to Head-End') }}</p>
                        <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">0</p>
                    </div>
                    <div class="h-2 w-2 rounded-full bg-purple-500"></div>
                </div>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Head-Ends') }}</p>
                        <p class="text-2xl font-bold text-orange-600 dark:text-orange-400">0</p>
                    </div>
                    <svg class="h-5 w-5 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- View Toggle -->
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <input type="text" placeholder="Search channels..." class="w-64 rounded-lg border border-neutral-200 bg-white px-3 py-2 text-sm dark:border-neutral-700 dark:bg-neutral-900 dark:text-white" />
            </div>
            <div class="flex items-center gap-2">
                <button @click="viewMode = 'table'" :class="viewMode === 'table' ? 'bg-neutral-900 text-white dark:bg-white dark:text-neutral-900' : 'bg-white text-neutral-700 hover:bg-neutral-50 dark:bg-neutral-800 dark:text-neutral-300 dark:hover:bg-neutral-700'" class="inline-flex items-center gap-2 rounded-lg border border-neutral-200 px-3 py-2 text-sm font-medium transition-colors dark:border-neutral-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                    {{ __('Table') }}
                </button>
                <button @click="viewMode = 'grid'" :class="viewMode === 'grid' ? 'bg-neutral-900 text-white dark:bg-white dark:text-neutral-900' : 'bg-white text-neutral-700 hover:bg-neutral-50 dark:bg-neutral-800 dark:text-neutral-300 dark:hover:bg-neutral-700'" class="inline-flex items-center gap-2 rounded-lg border border-neutral-200 px-3 py-2 text-sm font-medium transition-colors dark:border-neutral-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    {{ __('Grid') }}
                </button>
            </div>
        </div>

        <!-- Channels Section -->
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-center justify-between border-b border-neutral-200 p-6 dark:border-neutral-700">
                <div>
                    <h3 class="text-lg font-semibold">{{ __('IPTV Channels') }}</h3>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Manage your television channels and their configurations') }}</p>
                </div>
            </div>
            
            <!-- Table View -->
            <div x-show="viewMode === 'table'" class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-neutral-200 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                {{ __('Channel') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                {{ __('Stream Address') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                {{ __('Head-End') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                {{ __('Status') }}
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                        @foreach($channels as $channel)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/20 overflow-hidden">
                                        @if($channel->channel_logo)
                                            <img src="{{ asset('storage/' . $channel->channel_logo) }}" alt="{{ $channel->channel_name }}" class="h-full w-full object-cover rounded-lg">
                                        @else
                                            <span class="text-xs font-bold text-blue-600 dark:text-blue-400">{{ strtoupper(substr($channel->channel_name, 0, 3)) }}</span>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <span class="text-sm font-medium">{{ $channel->channel_name }}</span>
                                        @if($channel->channel_number)
                                            <div class="text-xs text-neutral-500 dark:text-neutral-400">Ch. {{ $channel->channel_number }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-mono" title="{{ $channel->stream_address }}">{{ \Illuminate\Support\Str::limit($channel->stream_address, 20) }}</span>
                                <div class="text-xs text-neutral-500 dark:text-neutral-400">{{ strtoupper($channel->protocol) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($channel->head_end_assignment)
                                    <div class="flex items-center space-x-2">
                                        <div class="h-2 w-2 rounded-full bg-green-500"></div>
                                        <span class="text-sm text-green-600 dark:text-green-400">{{ $channel->head_end_assignment }}</span>
                                    </div>
                                @else
                                    <div class="flex items-center space-x-2">
                                        <div class="h-2 w-2 rounded-full bg-neutral-400"></div>
                                        <span class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Unlinked') }}</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($channel->status === 'active')
                                    <div class="flex items-center space-x-2">
                                        <div class="h-2 w-2 rounded-full bg-green-500"></div>
                                        <span class="text-sm text-green-600 dark:text-green-400">{{ __('Active') }}</span>
                                    </div>
                                @else
                                    <div class="flex items-center space-x-2">
                                        <div class="h-2 w-2 rounded-full bg-red-500"></div>
                                        <span class="text-sm text-red-600 dark:text-red-400">{{ __('Inactive') }}</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <flux:modal.trigger name="edit-channel-modal">
                                    <button class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-neutral-700 bg-neutral-100 hover:bg-neutral-200 dark:text-neutral-300 dark:bg-neutral-700 dark:hover:bg-neutral-600" wire:click="openEditModal({{ $channel->id }})" wire:loading.attr="disabled" wire:target="openEditModal">
                                        <span wire:loading.remove wire:target="openEditModal" class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            {{ __('Settings') }}
                                        </span>
                                        <span wire:loading wire:target="openEditModal" class="flex items-center">
                                            <svg class="animate-spin -ml-1 mr-2 h-3 w-3" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            {{ __('Loading...') }}
                                        </span>
                                    </button>
                                </flux:modal.trigger>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Grid View -->
            <div x-show="viewMode === 'grid'" class="p-6">
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach($channels as $channel)
                    <div class="rounded-lg border border-neutral-200 bg-neutral-50 p-4 hover:shadow-md transition-shadow dark:border-neutral-600 dark:bg-neutral-800">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/20 overflow-hidden">
                                    @if($channel->channel_logo)
                                        <img src="{{ asset('storage/' . $channel->channel_logo) }}" alt="{{ $channel->channel_name }}" class="h-full w-full object-cover rounded-lg">
                                    @else
                                        <span class="text-sm font-bold text-blue-600 dark:text-blue-400">{{ strtoupper(substr($channel->channel_name, 0, 3)) }}</span>
                                    @endif
                                </div>
                                <div>
                                    <span class="text-sm font-medium">{{ $channel->channel_name }}</span>
                                    @if($channel->channel_number)
                                        <div class="text-xs text-neutral-500 dark:text-neutral-400">Ch. {{ $channel->channel_number }}</div>
                                    @endif
                                    <div class="text-xs text-neutral-500 dark:text-neutral-400 font-mono">{{ strtoupper($channel->protocol) }}</div>
                                </div>
                            </div>
                            @if($channel->status === 'active')
                                <div class="flex items-center space-x-1">
                                    <div class="h-2 w-2 rounded-full bg-green-500"></div>
                                    <span class="text-xs text-green-600 dark:text-green-400">{{ __('Active') }}</span>
                                </div>
                            @else
                                <div class="flex items-center space-x-1">
                                    <div class="h-2 w-2 rounded-full bg-red-500"></div>
                                    <span class="text-xs text-red-600 dark:text-red-400">{{ __('Inactive') }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('Head-End:') }}</span>
                                @if($channel->head_end_assignment)
                                    <span class="text-xs text-green-600 dark:text-green-400">{{ $channel->head_end_assignment }}</span>
                                @else
                                    <span class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('Unlinked') }}</span>
                                @endif
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('Stream:') }}</span>
                                <span class="text-xs text-neutral-600 dark:text-neutral-300 font-mono truncate max-w-32" title="{{ $channel->stream_address }}">{{ $channel->stream_address }}</span>
                            </div>
</div>

                        <div class="flex gap-2">
                            <flux:modal.trigger name="edit-channel-modal">
                                <button class="flex-1 inline-flex items-center justify-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-neutral-700 bg-neutral-100 hover:bg-neutral-200 dark:text-neutral-300 dark:bg-neutral-700 dark:hover:bg-neutral-600" wire:click="openEditModal({{ $channel->id }})" wire:loading.attr="disabled" wire:target="openEditModal">
                                    <span wire:loading.remove wire:target="openEditModal">{{ __('Settings') }}</span>
                                    <span wire:loading wire:target="openEditModal" class="flex items-center">
                                        <svg class="animate-spin -ml-1 mr-2 h-3 w-3" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        {{ __('Loading...') }}
                                    </span>
                                </button>
                            </flux:modal.trigger>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Add Channel Modal -->
    <flux:modal name="add-channel-modal" class="max-w-4xl" x-on:modal-close="$wire.resetForm()">
        <div class="p-6">
            <div class="mb-6">
                <flux:heading size="lg">{{ __('Add New Channel') }}</flux:heading>
                <flux:subheading>{{ __('Configure a new IPTV channel') }}</flux:subheading>
            </div>

            <form wire:submit="save" class="space-y-6">
                <div class="grid gap-6 md:grid-cols-2">
                    <!-- Basic Information -->
                    <div class="space-y-4">
                        <flux:heading size="base">{{ __('Basic Information') }}</flux:heading>
                        
                        <flux:field>
                            <flux:label for="channel_number">{{ __('Channel Number') }}</flux:label>
                            <flux:input type="number" id="channel_number" name="channel_number" wire:model="form.channel_number" placeholder="{{ __('Enter channel number (optional)') }}" />
                        </flux:field>

                        <flux:field>
                            <flux:label for="channel_name">{{ __('Channel Name') }}</flux:label>
                            <flux:input type="text" id="channel_name" name="channel_name" wire:model="form.channel_name" placeholder="{{ __('Enter channel name') }}" />
                        </flux:field>

                        <flux:field>
                            <flux:label for="channel_logo">{{ __('Channel Logo') }}</flux:label>
                            <flux:input type="file" id="channel_logo" name="channel_logo" wire:model="form.channel_logo" accept=".png,.jpg,.jpeg,.gif" />
                        </flux:field>
                    </div>

                    <!-- Stream Configuration -->
                    <div class="space-y-4">
                        <flux:heading size="base">{{ __('Stream Configuration') }}</flux:heading>
                        
                        <flux:field>
                            <flux:label for="protocol">{{ __('Protocol') }}</flux:label>
                            <flux:select id="protocol" name="protocol" wire:model="form.protocol">
                                <option value="">{{ __('Select Protocol') }}</option>
                                <option value="http">HTTP</option>
                                <option value="https">HTTPS</option>
                                <option value="rtmp">RTMP</option>
                                <option value="rtsp">RTSP</option>
                                <option value="udp">UDP</option>
                                <option value="hls">HLS</option>
                                <option value="dash">DASH</option>
                            </flux:select>
                        </flux:field>

                        <flux:field>
                            <flux:label for="stream_address">{{ __('Stream Address') }}</flux:label>
                            <flux:input type="text" id="stream_address" name="stream_address" wire:model="form.stream_address" placeholder="{{ __('Enter stream address') }}" />
                        </flux:field>

                        <flux:field>
                            <flux:label for="username">{{ __('Username') }}</flux:label>
                            <flux:input type="text" id="username" name="username" wire:model="form.username" placeholder="{{ __('Enter username (optional)') }}" />
                        </flux:field>

                        <flux:field>
                            <flux:label for="password">{{ __('Password') }}</flux:label>
                            <flux:input type="password" id="password" name="password" wire:model="form.password" placeholder="{{ __('Enter password (optional)') }}" />
                        </flux:field>
                    </div>
                </div>

                <div class="border-t border-neutral-200 pt-6 dark:border-neutral-700">
                    <flux:heading size="base" class="mb-4">{{ __('Additional Settings') }}</flux:heading>
                    
                    <div class="grid gap-4 md:grid-cols-2">
                        <flux:field>
                            <flux:label for="head_end_assignment">{{ __('Head-End Assignment') }}</flux:label>
                            <flux:select id="head_end_assignment" name="head_end_assignment" wire:model="form.head_end_assignment">
                                <option value="">{{ __('No Head-End') }}</option>
                                <option value="Head-End A">{{ __('Head-End A') }}</option>
                                <option value="Head-End B">{{ __('Head-End B') }}</option>
                                <option value="Head-End C">{{ __('Head-End C') }}</option>
                            </flux:select>
                        </flux:field>

                        <flux:field>
                            <flux:label for="status">{{ __('Channel Status') }}</flux:label>
                            <flux:select id="status" name="status" wire:model="form.status">
                                <option value="active">{{ __('Active') }}</option>
                                <option value="inactive">{{ __('Inactive') }}</option>
                            </flux:select>
                        </flux:field>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                    <flux:modal.close>
                        <flux:button variant="subtle">{{ __('Cancel') }}</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary">{{ __('Add Channel') }}</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    <!-- Edit Channel Modal -->
    <flux:modal name="edit-channel-modal" class="max-w-4xl" :show="$editingChannel !== null" x-on:modal-close="$wire.closeEditModal()">
        <div class="p-6">
            @if($loadingChannel)
                <div class="flex items-center justify-center py-12">
                    <div class="flex items-center space-x-3">
                        <svg class="animate-spin h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('Loading channel data...') }}</span>
                    </div>
                </div>
            @elseif($editingChannel)
            <div class="mb-6">
                <flux:heading size="lg">{{ __('Channel Settings - ') }}{{ $editingChannel->channel_name }}</flux:heading>
                <flux:subheading>{{ __('Stream: ') }}{{ $editingChannel->stream_address }}</flux:subheading>
            </div>

            <form wire:submit="save" class="space-y-6">
                <div class="grid gap-6 md:grid-cols-2">
                    <!-- Channel Configuration -->
                    <div class="space-y-4">
                        <flux:heading size="base">{{ __('Channel Configuration') }}</flux:heading>
                        
                        <flux:field>
                            <flux:label for="edit_channel_number">{{ __('Channel Number') }}</flux:label>
                            <flux:input type="number" id="edit_channel_number" name="edit_channel_number" wire:model="form.channel_number" />
                        </flux:field>
                        
                        <flux:field>
                            <flux:label for="edit_channel_name">{{ __('Channel Name') }}</flux:label>
                            <flux:input type="text" id="edit_channel_name" name="edit_channel_name" wire:model="form.channel_name" />
                        </flux:field>

                        <flux:field>
                            <flux:label for="edit_protocol">{{ __('Protocol') }}</flux:label>
                            <flux:select id="edit_protocol" name="edit_protocol" wire:model="form.protocol">
                                <option value="http">HTTP</option>
                                <option value="https">HTTPS</option>
                                <option value="rtmp">RTMP</option>
                                <option value="rtsp">RTSP</option>
                                <option value="udp">UDP</option>
                                <option value="hls">HLS</option>
                                <option value="dash">DASH</option>
                            </flux:select>
                        </flux:field>

                        <flux:field>
                            <flux:label for="edit_stream_address">{{ __('Stream Address') }}</flux:label>
                            <flux:input type="text" id="edit_stream_address" name="edit_stream_address" wire:model="form.stream_address" />
                        </flux:field>
                    </div>

                    <!-- Head-End Assignment -->
                    <div class="space-y-4">
                        <flux:heading size="base">{{ __('Head-End Assignment') }}</flux:heading>

                        <flux:field>
                            <flux:label for="edit_head_end_assignment">{{ __('Assigned Head-End') }}</flux:label>
                            <flux:select id="edit_head_end_assignment" name="edit_head_end_assignment" wire:model="form.head_end_assignment">
                                <option value="">{{ __('No Head-End') }}</option>
                                <option value="Head-End A">{{ __('Head-End A') }}</option>
                                <option value="Head-End B">{{ __('Head-End B') }}</option>
                                <option value="Head-End C">{{ __('Head-End C') }}</option>
                            </flux:select>
                        </flux:field>

                        <flux:field>
                            <flux:label for="edit_username">{{ __('Username') }}</flux:label>
                            <flux:input type="text" id="edit_username" name="edit_username" wire:model="form.username" />
                        </flux:field>

                        <flux:field>
                            <flux:label for="edit_password">{{ __('Password') }}</flux:label>
                            <flux:input type="password" id="edit_password" name="edit_password" wire:model="form.password" />
                        </flux:field>

                        <flux:field>
                            <flux:label for="edit_status">{{ __('Channel Status') }}</flux:label>
                            <flux:select id="edit_status" name="edit_status" wire:model="form.status">
                                <option value="active">{{ __('Active') }}</option>
                                <option value="inactive">{{ __('Inactive') }}</option>
                            </flux:select>
                        </flux:field>
                    </div>
                </div>

                <div class="flex justify-between items-center mt-6 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                    <!-- Delete Button -->
                    <div x-data="{ 
                        deleting: false,
                        deleteChannel() {
                            if (confirm('{{ __('Are you sure you want to delete this channel? This action cannot be undone.') }}')) {
                                this.deleting = true;
                                $wire.delete({{ $editingChannel->id }}).then(() => {
                                    this.deleting = false;
                                }).catch(() => {
                                    this.deleting = false;
                                });
                            }
                        }
                    }">
                        <button 
                            type="button" 
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 disabled:opacity-50 disabled:cursor-not-allowed"
                            @click="deleteChannel()" 
                            :disabled="deleting">
                            <svg x-show="!deleting" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            <svg x-show="deleting" class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span x-show="!deleting">{{ __('Delete Channel') }}</span>
                            <span x-show="deleting">{{ __('Deleting...') }}</span>
                        </button>
                    </div>

                    <!-- Save/Cancel Buttons -->
                    <div class="flex space-x-3">
                        <flux:modal.close>
                            <flux:button variant="subtle" wire:click="closeEditModal">{{ __('Cancel') }}</flux:button>
                        </flux:modal.close>
                        <flux:button type="submit" variant="primary">{{ __('Save Changes') }}</flux:button>
                    </div>
                </div>
            </form>
            @endif
        </div>
    </flux:modal>

    </div>
</div>