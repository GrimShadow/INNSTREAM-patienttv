<div class="flex h-full w-full flex-1 flex-col gap-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <flux:button variant="filled" icon="arrow-path" class="bg-blue-600 hover:bg-blue-700" wire:click="refreshAll">
                {{ __('Refresh All') }}
            </flux:button>
            <flux:button variant="outline" icon="heart" class="border-green-200 text-green-700 hover:bg-green-50 dark:border-green-800 dark:text-green-400 dark:hover:bg-green-900/20" wire:click="checkDisplayStatus">
                {{ __('Check Status') }}
            </flux:button>
            <flux:button variant="primary" icon="plus" wire:click="showAddModal">
                {{ __('Add Display') }}
            </flux:button>
        </div>
    </div>

    <!-- Status Overview Cards -->
    <div class="grid auto-rows-min gap-4 md:grid-cols-4">
        <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-center justify-between">
                <div>
                    <flux:subheading class="text-neutral-500 dark:text-neutral-400">{{ __('Online') }}</flux:subheading>
                    <flux:heading size="lg" class="mt-1 text-green-600 dark:text-green-400">{{ $this->stats['online'] }}</flux:heading>
                </div>
                <div class="h-2 w-2 rounded-full bg-green-500"></div>
            </div>
        </div>
        <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-center justify-between">
                <div>
                    <flux:subheading class="text-neutral-500 dark:text-neutral-400">{{ __('Offline') }}</flux:subheading>
                    <flux:heading size="lg" class="mt-1 text-red-600 dark:text-red-400">{{ $this->stats['offline'] }}</flux:heading>
                </div>
                <div class="h-2 w-2 rounded-full bg-red-500"></div>
            </div>
        </div>
        <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-center justify-between">
                <div>
                    <flux:subheading class="text-neutral-500 dark:text-neutral-400">{{ __('Powered Off') }}</flux:subheading>
                    <flux:heading size="lg" class="mt-1 text-yellow-600 dark:text-yellow-400">{{ $this->stats['poweredOff'] }}</flux:heading>
                </div>
                <div class="h-2 w-2 rounded-full bg-yellow-500"></div>
            </div>
        </div>
        <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-center justify-between">
                <div>
                    <flux:subheading class="text-neutral-500 dark:text-neutral-400">{{ __('Total') }}</flux:subheading>
                    <flux:heading size="lg" class="mt-1 text-neutral-900 dark:text-neutral-100">{{ $this->stats['total'] }}</flux:heading>
                </div>
                <img src="https://cdn.devdojo.com/tails/images/VFvAoIInEk7ph2OjAejKkW9BpNE8R1xsyI1MK4UH.png" class="w-18 h-18 object-cover object-center rounded-lg">
            </div>
        </div>
    </div>

    <!-- View Toggle and Content Container -->
    <div>
        <!-- Filters and Search -->
        <div class="flex items-center justify-between gap-4 mb-6">
            <div class="flex items-center gap-3">
                <flux:input 
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search displays..." 
                    class="w-64" 
                    icon="magnifying-glass" 
                />
                <select
                    wire:model.live="statusFilter"
                    class="w-40 rounded-lg border border-neutral-200 bg-white px-3 py-2 text-sm dark:border-neutral-700 dark:bg-neutral-900 dark:text-white">
                    <option value="all">{{ __('All Status') }}</option>
                    <option value="online">{{ __('Online') }}</option>
                    <option value="offline">{{ __('Offline') }}</option>
                    <option value="powered_off">{{ __('Powered Off') }}</option>
                    <option value="maintenance">{{ __('Maintenance') }}</option>
                </select>
                <select
                    wire:model.live="floorFilter"
                    class="w-32 rounded-lg border border-neutral-200 bg-white px-3 py-2 text-sm dark:border-neutral-700 dark:bg-neutral-900 dark:text-white">
                    <option value="all">{{ __('All Floors') }}</option>
                    @foreach($this->floors as $floor)
                        <option value="{{ $floor }}">{{ __('Floor') }} {{ $floor }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-center gap-2">
                <button @click="$wire.viewMode = 'table'"
                    :class="$wire.viewMode === 'table' ? 'bg-neutral-900 text-white dark:bg-white dark:text-neutral-900' : 'bg-white text-neutral-700 hover:bg-neutral-50 dark:bg-neutral-800 dark:text-neutral-300 dark:hover:bg-neutral-700'"
                    class="inline-flex items-center gap-2 rounded-lg border border-neutral-200 px-3 py-2 text-sm font-medium transition-colors dark:border-neutral-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    {{ __('Table') }}
                </button>
                <button @click="$wire.viewMode = 'grid'"
                    :class="$wire.viewMode === 'grid' ? 'bg-neutral-900 text-white dark:bg-white dark:text-neutral-900' : 'bg-white text-neutral-700 hover:bg-neutral-50 dark:bg-neutral-800 dark:text-neutral-300 dark:hover:bg-neutral-700'"
                    class="inline-flex items-center gap-2 rounded-lg border border-neutral-200 px-3 py-2 text-sm font-medium transition-colors dark:border-neutral-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                    {{ __('Grid') }}
                </button>
            </div>
        </div>

        <!-- Displays Content -->
        <!-- Table View -->
        <div x-show="$wire.viewMode === 'table'"
            class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead
                        class="border-b border-neutral-200 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-800">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                {{ __('Display') }}
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                {{ __('Status') }}
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                {{ __('Template') }}
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                {{ __('Network') }}
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                {{ __('Last Seen') }}
                            </th>
                            <th
                                class="px-6 py-3 text-right text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                        @forelse($this->displays as $display)
                            <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-lg">
                                            <img src="https://cdn.devdojo.com/tails/images/xdzOHV9YTcml7C3LNKEn19pPrwDoj1kv74UWpS6h.png" class="w-18 h-18 object-cover object-center rounded-lg">
                                        </div>
                                        <div class="ml-4">
                                            <flux:text class="text-sm font-medium">{{ $display->name }}</flux:text>
                                            <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">
                                                {{ $display->make }} {{ $display->model }}
                                            </flux:text>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <div class="h-2 w-2 rounded-full {{ $display->online ? 'bg-green-500' : 'bg-red-500' }}"></div>
                                        <flux:text class="text-sm {{ $display->online ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            {{ $display->online ? __('Online') : __('Offline') }}
                                        </flux:text>
                                    </div>
                                    @if($display->connection_code)
                                        <div class="mt-1">
                                            <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">
                                                Code: <span class="font-mono font-bold">{{ $display->connection_code }}</span>
                                            </flux:text>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($display->template)
                                        <flux:text class="text-sm">{{ $display->template->name }}</flux:text>
                                        <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">
                                            {{ __('Active') }}
                                        </flux:text>
                                    @else
                                        <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">
                                            {{ __('No template') }}
                                        </flux:text>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <flux:text class="text-sm">{{ $display->ip_address ?? __('N/A') }}</flux:text>
                                    <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">
                                        {{ $display->mac_address ?? __('N/A') }}
                                    </flux:text>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($display->last_seen_at)
                                        <flux:text class="text-sm">{{ $display->last_seen_at->diffForHumans() }}</flux:text>
                                    @else
                                        <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Never') }}</flux:text>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <flux:button 
                                            variant="subtle" 
                                            size="sm" 
                                            icon="{{ $display->status === 'online' ? 'power' : 'play' }}"
                                            class="{{ $display->status === 'online' ? 'text-green-600 hover:text-green-700' : 'text-yellow-600 hover:text-yellow-700' }}"
                                            wire:click="toggleDisplayStatus({{ $display->id }})"
                                            title="{{ $display->status === 'online' ? 'Set Offline' : 'Set Online' }}"
                                        >
                                            {{ $display->status === 'online' ? __('Offline') : __('Online') }}
                                        </flux:button>
                                        <flux:button variant="subtle" size="sm" icon="ellipsis-horizontal" wire:click="editDisplay({{ $display->id }})">
                                            {{ __('More') }}
                                        </flux:button>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <flux:text class="text-neutral-500 dark:text-neutral-400">{{ __('No displays found') }}</flux:text>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-3 border-t border-neutral-200 dark:border-neutral-700">
                {{ $this->displays->links() }}
            </div>
        </div>

        <!-- Grid View -->
        <div x-show="$wire.viewMode === 'grid'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($this->displays as $display)
                <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/20">
                                <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <flux:heading size="sm">{{ $display->name }}</flux:heading>
                                <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">
                                    {{ $display->make }} {{ $display->model }}
                                </flux:text>
                            </div>
                        </div>
                        <div class="h-3 w-3 rounded-full {{ $display->online ? 'bg-green-500' : 'bg-red-500' }}"></div>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('Status') }}</flux:text>
                            <flux:text class="text-xs font-medium {{ $display->online ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ $display->online ? __('Online') : __('Offline') }}
                            </flux:text>
                        </div>
                        @if($display->connection_code)
                            <div class="flex justify-between">
                                <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('Connection Code') }}</flux:text>
                                <flux:text class="text-xs font-mono font-bold">{{ $display->connection_code }}</flux:text>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('Location') }}</flux:text>
                            <flux:text class="text-xs font-medium">{{ $display->location ?? __('N/A') }}</flux:text>
                        </div>
                        <div class="flex justify-between">
                            <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('IP Address') }}</flux:text>
                            <flux:text class="text-xs font-medium">{{ $display->ip_address ?? __('N/A') }}</flux:text>
                        </div>
                        @if($display->template)
                            <div class="flex justify-between">
                                <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('Template') }}</flux:text>
                                <flux:text class="text-xs font-medium">{{ $display->template->name }}</flux:text>
                            </div>
                        @endif
                    </div>
                    
                    <div class="mt-4 flex gap-2">
                        <flux:button 
                            variant="subtle" 
                            size="sm" 
                            icon="{{ $display->status === 'online' ? 'power' : 'play' }}"
                            class="{{ $display->status === 'online' ? 'text-green-600 hover:text-green-700' : 'text-yellow-600 hover:text-yellow-700' }}"
                            wire:click="toggleDisplayStatus({{ $display->id }})"
                            title="{{ $display->status === 'online' ? 'Set Offline' : 'Set Online' }}"
                        >
                            {{ $display->status === 'online' ? __('Offline') : __('Online') }}
                        </flux:button>
                        <flux:button variant="subtle" size="sm" class="flex-1" wire:click="editDisplay({{ $display->id }})">
                            {{ __('More') }}
                        </flux:button>

                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <flux:text class="text-neutral-500 dark:text-neutral-400">{{ __('No displays found') }}</flux:text>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Add/Edit Display Modal -->
                    <flux:modal name="add-display-modal" wire:model="showAddModal" class="max-w-4xl">
                    <div class="p-6">
                        <div class="mb-6">
                            <flux:heading size="lg">{{ $editingDisplay ? __('Display Details') : __('Add New Display') }}</flux:heading>
                        </div>

                        @if($editingDisplay)
                            <!-- Tabs for Edit Mode -->
                            <div class="border-b border-neutral-200 dark:border-neutral-700 mb-6">
                                <nav class="-mb-px flex space-x-8">
                                    <button 
                                        wire:click="switchTab('edit')"
                                        class="py-2 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'edit' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-neutral-500 hover:text-neutral-700 hover:border-neutral-300 dark:text-neutral-400 dark:hover:text-neutral-300' }}"
                                    >
                                        {{ __('Edit') }}
                                    </button>
                                    <button 
                                        wire:click="switchTab('actions')"
                                        class="py-2 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'actions' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-neutral-500 hover:text-neutral-700 hover:border-neutral-300 dark:text-neutral-400 dark:hover:text-neutral-300' }}"
                                    >
                                        {{ __('Actions') }}
                                    </button>
                                </nav>
                            </div>
                        @endif
            
                                    @if(!$editingDisplay || $activeTab === 'edit')
                            <form wire:submit="saveDisplay" class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Editable Fields -->
                                    <div>
                                        <flux:field>
                                            <flux:label for="name">{{ __('Display Name') }} *</flux:label>
                                            <flux:input id="name" wire:model="name" placeholder="Enter display name" />
                                        </flux:field>
                                        @error('name') <flux:error>{{ $message }}</flux:error> @enderror
                                    </div>

                    <div>
                        <flux:field>
                            <flux:label for="location">{{ __('Location') }}</flux:label>
                            <flux:input id="location" wire:model="location" placeholder="e.g., Main Lobby" />
                        </flux:field>
                        @error('location') <flux:error>{{ $message }}</flux:error> @enderror
                    </div>

                    <div>
                        <flux:field>
                            <flux:label for="floor">{{ __('Floor') }}</flux:label>
                            <flux:input id="floor" wire:model="floor" placeholder="e.g., Ground, 1st, 2nd" />
                        </flux:field>
                        @error('floor') <flux:error>{{ $message }}</flux:error> @enderror
                    </div>

                    <div>
                        <flux:field>
                            <flux:label for="room">{{ __('Room') }}</flux:label>
                            <flux:input id="room" wire:model="room" placeholder="e.g., Lobby, Conference A" />
                        </flux:field>
                        @error('room') <flux:error>{{ $message }}</flux:error> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <flux:field>
                            <flux:label for="template_id">{{ __('Template') }}</flux:label>
                            <flux:select id="template_id" wire:model="template_id">
                                <option value="">{{ __('No Template') }}</option>
                                @foreach($this->templates as $template)
                                    <option value="{{ $template->id }}">{{ $template->name }}</option>
                                @endforeach
                            </flux:select>
                            @error('template_id') <flux:error>{{ $message }}</flux:error> @enderror
                        </flux:field>
                    </div>

                    @if($editingDisplay)
                        <!-- Read-only Fields for Edit Mode -->
                        <div class="md:col-span-2 mt-6">
                            <flux:heading size="sm" class="mb-4 text-neutral-600 dark:text-neutral-400">{{ __('Display Information (Read-only)') }}</flux:heading>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <flux:field>
                                        <flux:label>{{ __('Make') }}</flux:label>
                                        <flux:input value="{{ $make }}" disabled />
                                    </flux:field>
                                </div>

                                <div>
                                    <flux:field>
                                        <flux:label>{{ __('Model') }}</flux:label>
                                        <flux:input value="{{ $model }}" disabled />
                                    </flux:field>
                                </div>

                                <div>
                                    <flux:field>
                                        <flux:label>{{ __('IP Address') }}</flux:label>
                                        <flux:input value="{{ $ip_address }}" disabled />
                                    </flux:field>
                                </div>

                                <div>
                                    <flux:field>
                                        <flux:label>{{ __('MAC Address') }}</flux:label>
                                        <flux:input value="{{ $mac_address }}" disabled />
                                    </flux:field>
                                </div>

                                <div>
                                    <flux:field>
                                        <flux:label>{{ __('Operating System') }}</flux:label>
                                        <flux:input value="{{ $os }}" disabled />
                                    </flux:field>
                                </div>

                                <div>
                                    <flux:field>
                                        <flux:label>{{ __('OS Version') }}</flux:label>
                                        <flux:input value="{{ $version }}" disabled />
                                    </flux:field>
                                </div>

                                <div>
                                    <flux:field>
                                        <flux:label>{{ __('Firmware Version') }}</flux:label>
                                        <flux:input value="{{ $firmware_version }}" disabled />
                                    </flux:field>
                                </div>

                                <div>
                                    <flux:field>
                                        <flux:label>{{ __('Status') }}</flux:label>
                                        <flux:input value="{{ ucfirst($editingDisplay->status) }}" disabled />
                                    </flux:field>
                                </div>
                            </div>
                        </div>

                        <!-- Danger Zone for Edit Tab -->
                        <div class="md:col-span-2 mt-6 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                            <flux:heading size="sm" class="mb-4 text-red-600 dark:text-red-400">{{ __('Danger Zone') }}</flux:heading>
                            <flux:button 
                                variant="outline" 
                                class="border-red-200 text-red-700 hover:bg-red-50 dark:border-red-800 dark:text-red-400 dark:hover:bg-red-900/20"
                                wire:click="deleteDisplay({{ $editingDisplay->id }})"
                                onclick="return confirm('{{ __('Are you sure you want to delete this display? This action cannot be undone.') }}')"
                            >
                                <flux:icon name="trash" class="w-4 h-4 mr-2" />
                                {{ __('Delete Display') }}
                            </flux:button>
                        </div>
                    @else
                        <!-- All Fields for Add Mode -->
                        <div>
                            <flux:field>
                                <flux:label for="make">{{ __('Make') }}</flux:label>
                                <flux:input id="make" wire:model="make" placeholder="e.g., LG, Samsung, Sony" />
                            </flux:field>
                            @error('make') <flux:error>{{ $message }}</flux:error> @enderror
                        </div>

                        <div>
                            <flux:field>
                                <flux:label for="model">{{ __('Model') }}</flux:label>
                                <flux:input id="model" wire:model="model" placeholder="e.g., 55UN7300PUF" />
                            </flux:field>
                            @error('model') <flux:error>{{ $message }}</flux:error> @enderror
                        </div>

                        <div>
                            <flux:field>
                                <flux:label for="ip_address">{{ __('IP Address') }}</flux:label>
                                <flux:input id="ip_address" wire:model="ip_address" placeholder="192.168.1.100" />
                            </flux:field>
                            @error('ip_address') <flux:error>{{ $message }}</flux:error> @enderror
                        </div>

                        <div>
                            <flux:field>
                                <flux:label for="mac_address">{{ __('MAC Address') }}</flux:label>
                                <flux:input id="mac_address" wire:model="mac_address" placeholder="00:1B:44:11:3A:B7" />
                            </flux:field>
                            @error('mac_address') <flux:error>{{ $message }}</flux:error> @enderror
                        </div>

                        <div>
                            <flux:field>
                                <flux:label for="os">{{ __('Operating System') }}</flux:label>
                                <flux:input id="os" wire:model="os" placeholder="e.g., WebOS, Tizen, Android TV" />
                            </flux:field>
                            @error('os') <flux:error>{{ $message }}</flux:error> @enderror
                        </div>

                        <div>
                            <flux:field>
                                <flux:label for="version">{{ __('OS Version') }}</flux:label>
                                <flux:input id="version" wire:model="version" placeholder="e.g., 6.0" />
                            </flux:field>
                            @error('version') <flux:error>{{ $message }}</flux:error> @enderror
                        </div>

                        <div>
                            <flux:field>
                                <flux:label for="firmware_version">{{ __('Firmware Version') }}</flux:label>
                                <flux:input id="firmware_version" wire:model="firmware_version" placeholder="e.g., 03.21.16" />
                            </flux:field>
                            @error('firmware_version') <flux:error>{{ $message }}</flux:error> @enderror
                        </div>
                    @endif
                </div>
            </form>
        @endif

        @if($editingDisplay && $activeTab === 'actions')
            <!-- Actions Tab Content -->
            <div class="space-y-6">
                <!-- Display Status Overview -->
                <div class="bg-neutral-50 dark:bg-neutral-800 rounded-lg p-4 border border-neutral-200 dark:border-neutral-700">
                    <flux:heading size="sm" class="mb-3 text-neutral-700 dark:text-neutral-300">{{ __('Display Status') }}</flux:heading>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div>
                            <flux:text class="text-neutral-500 dark:text-neutral-400">{{ __('Status') }}</flux:text>
                            <flux:text class="block font-medium {{ $editingDisplay->status === 'online' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ ucfirst($editingDisplay->status) }}
                            </flux:text>
                        </div>
                        <div>
                            <flux:text class="text-neutral-500 dark:text-neutral-400">{{ __('IP Address') }}</flux:text>
                            <flux:text class="block font-medium">{{ $editingDisplay->ip_address ?? __('N/A') }}</flux:text>
                        </div>
                        <div>
                            <flux:text class="text-neutral-500 dark:text-neutral-400">{{ __('Last Seen') }}</flux:text>
                            <flux:text class="block font-medium">{{ $editingDisplay->last_seen_at ? $editingDisplay->last_seen_at->diffForHumans() : __('Never') }}</flux:text>
                        </div>
                        <div>
                            <flux:text class="text-neutral-500 dark:text-neutral-400">{{ __('Template') }}</flux:text>
                            <flux:text class="block font-medium">{{ $editingDisplay->template?->name ?? __('None') }}</flux:text>
                        </div>
                    </div>
                </div>

                <flux:heading size="sm" class="text-neutral-600 dark:text-neutral-400">{{ __('Display Control Actions') }}</flux:heading>
                
                <!-- Power Control -->
                <div class="space-y-4">
                    <flux:heading size="xs" class="text-neutral-500 dark:text-neutral-400">{{ __('Power Management') }}</flux:heading>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <flux:button 
                            variant="outline" 
                            class="border-green-200 text-green-700 hover:bg-green-50 dark:border-green-800 dark:text-green-400 dark:hover:bg-green-900/20"
                            wire:click="$set('powerAction', 'power_on'); powerControl({{ $editingDisplay->id }})"
                        >
                            <flux:icon name="play" class="w-4 h-4 mr-2" />
                            {{ __('Power On') }}
                        </flux:button>
                        
                        <flux:button 
                            variant="outline" 
                            class="border-red-200 text-red-700 hover:bg-red-50 dark:border-red-800 dark:text-red-400 dark:hover:bg-red-900/20"
                            wire:click="$set('powerAction', 'power_off'); powerControl({{ $editingDisplay->id }})"
                        >
                            <flux:icon name="power" class="w-4 h-4 mr-2" />
                            {{ __('Power Off') }}
                        </flux:button>
                        
                        <flux:button 
                            variant="outline" 
                            class="border-yellow-200 text-yellow-700 hover:bg-yellow-50 dark:border-yellow-800 dark:text-yellow-400 dark:hover:bg-yellow-900/20"
                            wire:click="$set('powerAction', 'restart'); powerControl({{ $editingDisplay->id }})"
                        >
                            <flux:icon name="arrow-path" class="w-4 h-4 mr-2" />
                            {{ __('Restart') }}
                        </flux:button>
                    </div>
                </div>

                <!-- Volume Control -->
                <div class="space-y-4">
                    <flux:heading size="xs" class="text-neutral-500 dark:text-neutral-400">{{ __('Volume Control') }}</flux:heading>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <flux:label>{{ __('Volume') }}: {{ $volume }}%</flux:label>
                            <flux:button 
                                variant="subtle" 
                                size="sm" 
                                wire:click="setVolume({{ $editingDisplay->id }})"
                            >
                                {{ __('Set Volume') }}
                            </flux:button>
                        </div>
                        <input 
                            type="range" 
                            wire:model="volume" 
                            min="0" 
                            max="100" 
                            class="w-full h-2 bg-neutral-200 rounded-lg appearance-none cursor-pointer dark:bg-neutral-700"
                        />
                    </div>
                </div>

                <!-- Brightness Control -->
                <div class="space-y-4">
                    <flux:heading size="xs" class="text-neutral-500 dark:text-neutral-400">{{ __('Brightness Control') }}</flux:heading>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <flux:label>{{ __('Brightness') }}: {{ $brightness }}%</flux:label>
                            <flux:button 
                                variant="subtle" 
                                size="sm" 
                                wire:click="setBrightness({{ $editingDisplay->id }})"
                            >
                                {{ __('Set Brightness') }}
                            </flux:button>
                        </div>
                        <input 
                            type="range" 
                            wire:model="brightness" 
                            min="0" 
                            max="100" 
                            class="w-full h-2 bg-neutral-200 rounded-lg appearance-none cursor-pointer dark:bg-neutral-700"
                        />
                    </div>
                </div>

                <!-- Quick Status Toggle -->
                <div class="space-y-4">
                    <flux:heading size="xs" class="text-neutral-500 dark:text-neutral-400">{{ __('Quick Actions') }}</flux:heading>
                    <flux:button 
                        variant="outline" 
                        class="w-full {{ $editingDisplay->status === 'online' ? 'border-red-200 text-red-700 hover:bg-red-50 dark:border-red-800 dark:text-red-400 dark:hover:bg-red-900/20' : 'border-green-200 text-green-700 hover:bg-green-50 dark:border-green-800 dark:text-green-400 dark:hover:bg-green-900/20' }}"
                        wire:click="toggleDisplayStatus({{ $editingDisplay->id }})"
                    >
                        <flux:icon name="{{ $editingDisplay->status === 'online' ? 'power' : 'play' }}" class="w-4 h-4 mr-2 {{ $editingDisplay->status === 'online' ? 'text-red-600' : 'text-green-600' }}" />
                        {{ $editingDisplay->status === 'online' ? __('Set Offline') : __('Set Online') }}
                    </flux:button>
                </div>

                <!-- Danger Zone -->
                <div class="space-y-4 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                    <flux:heading size="xs" class="text-red-600 dark:text-red-400">{{ __('Danger Zone') }}</flux:heading>
                    <flux:button 
                        variant="outline" 
                        class="w-full border-red-200 text-red-700 hover:bg-red-50 dark:border-red-800 dark:text-red-400 dark:hover:bg-red-900/20"
                        wire:click="deleteDisplay({{ $editingDisplay->id }})"
                        onclick="return confirm('{{ __('Are you sure you want to delete this display? This action cannot be undone.') }}')"
                    >
                        <flux:icon name="trash" class="w-4 h-4 mr-2" />
                        {{ __('Delete Display') }}
                    </flux:button>
                </div>
            </div>
        @endif
    </div>
    
    <div class="flex items-center justify-end gap-3 px-6 py-4 bg-neutral-50 dark:bg-neutral-800 border-t border-neutral-200 dark:border-neutral-700">
        <flux:button variant="subtle" wire:click="hideAddModal">
            {{ __('Cancel') }}
        </flux:button>
        @if(!$editingDisplay || $activeTab === 'edit')
            <flux:button variant="primary" wire:click="saveDisplay">
                {{ $editingDisplay ? __('Update Display') : __('Add Display') }}
            </flux:button>
        @endif
    </div>
    </flux:modal>
</div>
