<x-layouts.app :title="__('Template UI Editor')">
    <div class="flex h-full w-full flex-1 flex-col" x-data="{ 
        selectedTemplate: 'welcome',
        selectedComponent: null,
        previewMode: 'desktop',
        showComponentLibrary: true,
        showPropertiesPanel: true,
        components: [
            { id: 1, type: 'header', title: 'Welcome to Grand Hotel', position: { x: 50, y: 100 } },
            { id: 2, type: 'text', content: 'We hope you enjoy your stay with us', position: { x: 50, y: 200 } },
            { id: 3, type: 'image', src: 'hotel-logo.png', position: { x: 300, y: 50 } },
            { id: 4, type: 'weather', location: 'Current Location', position: { x: 50, y: 300 } }
        ]
    }">
        <!-- Navigation & Header -->
        <div class="flex items-center justify-between border-b border-neutral-200 p-6 dark:border-neutral-700">
            <flux:navbar scrollable>
                <flux:navbar.item href="{{ route('template-management') }}">Overview</flux:navbar.item>
                <flux:navbar.item href="{{ route('template-ui') }}" :current="request()->routeIs('template-ui')">UI</flux:navbar.item>
                <flux:navbar.item href="{{ route('templates') }}">Templates</flux:navbar.item>
            </flux:navbar>

            <div class="flex items-center gap-3">
                <!-- Preview Mode Toggle -->
                <div class="flex items-center gap-1 rounded-lg border border-neutral-200 p-1 dark:border-neutral-700">
                    <button @click="previewMode = 'desktop'" :class="previewMode === 'desktop' ? 'bg-neutral-900 text-white dark:bg-white dark:text-neutral-900' : 'text-neutral-600 hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100'" class="rounded px-3 py-1 text-sm font-medium transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="2" y="4" width="20" height="16" rx="2"/>
                            <path d="M2 8h20"/>
                        </svg>
                    </button>
                    <button @click="previewMode = 'tablet'" :class="previewMode === 'tablet' ? 'bg-neutral-900 text-white dark:bg-white dark:text-neutral-900' : 'text-neutral-600 hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100'" class="rounded px-3 py-1 text-sm font-medium transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="5" y="2" width="14" height="20" rx="2"/>
                            <path d="M9 22h6"/>
                        </svg>
                    </button>
                    <button @click="previewMode = 'mobile'" :class="previewMode === 'mobile' ? 'bg-neutral-900 text-white dark:bg-white dark:text-neutral-900' : 'text-neutral-600 hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100'" class="rounded px-3 py-1 text-sm font-medium transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="7" y="2" width="10" height="20" rx="2"/>
                            <path d="M11 18h2"/>
                        </svg>
                    </button>
                </div>

                <flux:button variant="subtle" @click="showComponentLibrary = !showComponentLibrary">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    <span x-text="showComponentLibrary ? '{{ __('Hide Components') }}' : '{{ __('Show Components') }}'"></span>
                </flux:button>

                <flux:button variant="filled" icon="eye">
                    {{ __('Preview') }}
                </flux:button>

                <flux:modal.trigger name="publish-template-modal">
                    <flux:button variant="primary" icon="check">
                        {{ __('Publish') }}
                    </flux:button>
                </flux:modal.trigger>
            </div>
        </div>

        <div class="flex flex-1 overflow-hidden">
            <!-- Template Selection Sidebar -->
            <div class="w-64 border-r border-neutral-200 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-900/50">
                <div class="p-4">
                    <flux:heading size="sm" class="mb-4">{{ __('Templates') }}</flux:heading>
                    
                    <div class="space-y-2">
                        @php
                            $templates = [
                                ['id' => 'welcome', 'name' => 'Welcome Template', 'description' => 'Guest welcome screen', 'preview' => 'welcome-preview.jpg'],
                                ['id' => 'info', 'name' => 'Hotel Information', 'description' => 'Services & amenities', 'preview' => 'info-preview.jpg'],
                                ['id' => 'events', 'name' => 'Event Schedule', 'description' => 'Daily events & activities', 'preview' => 'events-preview.jpg'],
                                ['id' => 'weather', 'name' => 'Weather & News', 'description' => 'Local updates', 'preview' => 'weather-preview.jpg'],
                                ['id' => 'spa', 'name' => 'Spa & Wellness', 'description' => 'Spa services', 'preview' => 'spa-preview.jpg'],
                                ['id' => 'restaurant', 'name' => 'Restaurant Menu', 'description' => 'Dining options', 'preview' => 'menu-preview.jpg']
                            ];
                        @endphp
                        
                        @foreach($templates as $template)
                        <div @click="selectedTemplate = '{{ $template['id'] }}'" :class="selectedTemplate === '{{ $template['id'] }}' ? 'bg-blue-50 border-blue-200 dark:bg-blue-900/20 dark:border-blue-800' : 'bg-white dark:bg-neutral-800 hover:bg-neutral-50 dark:hover:bg-neutral-700'" class="cursor-pointer rounded-lg border border-neutral-200 p-2 transition-colors dark:border-neutral-700">
                            <div class="flex items-center gap-2">
                                <div class="h-10 w-12 rounded bg-neutral-200 dark:bg-neutral-700 flex items-center justify-center flex-shrink-0">
                                    <svg class="h-4 w-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <flux:text class="text-xs font-medium">{{ $template['name'] }}</flux:text>
                                    <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ $template['description'] }}</flux:text>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Create New Template -->
                    <div class="mt-4 pt-4 border-t border-neutral-200 dark:border-neutral-700">
                        <flux:button variant="subtle" class="w-full" icon="plus">
                            {{ __('Create New Template') }}
                        </flux:button>
                    </div>
                </div>
            </div>

            <!-- Component Library Sidebar -->
            <div x-show="showComponentLibrary" class="w-64 border-r border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
                <div class="p-4">
                    <div class="flex items-center justify-between mb-4">
                        <flux:heading size="sm">{{ __('Components') }}</flux:heading>
                        <button @click="showComponentLibrary = false" class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="space-y-4">
                        <!-- Layout Components -->
                        <div>
                            <flux:text class="text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider mb-2">{{ __('Layout') }}</flux:text>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="flex flex-col items-center p-3 border border-neutral-200 rounded-lg hover:bg-neutral-50 cursor-pointer dark:border-neutral-700 dark:hover:bg-neutral-800">
                                    <svg class="h-8 w-8 text-neutral-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5z"/>
                                    </svg>
                                    <flux:text class="text-xs">{{ __('Header') }}</flux:text>
                                </div>
                                <div class="flex flex-col items-center p-3 border border-neutral-200 rounded-lg hover:bg-neutral-50 cursor-pointer dark:border-neutral-700 dark:hover:bg-neutral-800">
                                    <svg class="h-8 w-8 text-neutral-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                    </svg>
                                    <flux:text class="text-xs">{{ __('Text Block') }}</flux:text>
                                </div>
                                <div class="flex flex-col items-center p-3 border border-neutral-200 rounded-lg hover:bg-neutral-50 cursor-pointer dark:border-neutral-700 dark:hover:bg-neutral-800">
                                    <svg class="h-8 w-8 text-neutral-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/>
                                    </svg>
                                    <flux:text class="text-xs">{{ __('Columns') }}</flux:text>
                                </div>
                                <div class="flex flex-col items-center p-3 border border-neutral-200 rounded-lg hover:bg-neutral-50 cursor-pointer dark:border-neutral-700 dark:hover:bg-neutral-800">
                                    <svg class="h-8 w-8 text-neutral-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <flux:text class="text-xs">{{ __('Image') }}</flux:text>
                                </div>
                            </div>
                        </div>

                        <!-- Content Components -->
                        <div>
                            <flux:text class="text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider mb-2">{{ __('Content') }}</flux:text>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="flex flex-col items-center p-3 border border-neutral-200 rounded-lg hover:bg-neutral-50 cursor-pointer dark:border-neutral-700 dark:hover:bg-neutral-800">
                                    <svg class="h-8 w-8 text-neutral-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                    <flux:text class="text-xs">{{ __('Weather') }}</flux:text>
                                </div>
                                <div class="flex flex-col items-center p-3 border border-neutral-200 rounded-lg hover:bg-neutral-50 cursor-pointer dark:border-neutral-700 dark:hover:bg-neutral-800">
                                    <svg class="h-8 w-8 text-neutral-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <flux:text class="text-xs">{{ __('Clock') }}</flux:text>
                                </div>
                                <div class="flex flex-col items-center p-3 border border-neutral-200 rounded-lg hover:bg-neutral-50 cursor-pointer dark:border-neutral-700 dark:hover:bg-neutral-800">
                                    <svg class="h-8 w-8 text-neutral-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <flux:text class="text-xs">{{ __('Events') }}</flux:text>
                                </div>
                                <div class="flex flex-col items-center p-3 border border-neutral-200 rounded-lg hover:bg-neutral-50 cursor-pointer dark:border-neutral-700 dark:hover:bg-neutral-800">
                                    <svg class="h-8 w-8 text-neutral-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <flux:text class="text-xs">{{ __('Menu') }}</flux:text>
                                </div>
                                <div class="flex flex-col items-center p-3 border border-neutral-200 rounded-lg hover:bg-neutral-50 cursor-pointer dark:border-neutral-700 dark:hover:bg-neutral-800">
                                    <svg class="h-8 w-8 text-neutral-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <flux:text class="text-xs">{{ __('Information') }}</flux:text>
                                </div>
                                <div class="flex flex-col items-center p-3 border border-neutral-200 rounded-lg hover:bg-neutral-50 cursor-pointer dark:border-neutral-700 dark:hover:bg-neutral-800">
                                    <svg class="h-8 w-8 text-neutral-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                    <flux:text class="text-xs">{{ __('Video') }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Canvas Area -->
            <div class="flex-1 flex flex-col">
                <!-- Canvas Toolbar -->
                <div class="border-b border-neutral-200 p-4 dark:border-neutral-700">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <flux:text class="text-sm font-medium">{{ __('Welcome Template') }}</flux:text>
                            <div class="flex items-center gap-2 text-xs text-neutral-500 dark:text-neutral-400">
                                <span>{{ __('Last saved:') }}</span>
                                <span>{{ __('2 minutes ago') }}</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <!-- Zoom Controls -->
                            <div class="flex items-center gap-1 rounded border border-neutral-200 dark:border-neutral-700">
                                <button class="px-2 py-1 text-sm hover:bg-neutral-50 dark:hover:bg-neutral-800">-</button>
                                <span class="px-2 py-1 text-sm border-x border-neutral-200 dark:border-neutral-700">100%</span>
                                <button class="px-2 py-1 text-sm hover:bg-neutral-50 dark:hover:bg-neutral-800">+</button>
                            </div>
                            
                            <!-- Canvas Actions -->
                            <flux:button variant="subtle" size="sm" icon="arrow-uturn-left">
                                {{ __('Undo') }}
                            </flux:button>
                            <flux:button variant="subtle" size="sm" icon="arrow-uturn-right">
                                {{ __('Redo') }}
                            </flux:button>
                        </div>
                    </div>
                </div>

                <!-- Canvas -->
                <div class="flex-1 bg-neutral-100 dark:bg-neutral-800 p-4 overflow-auto">
                    <div class="flex justify-center">
                        <!-- Device Frame -->
                        <div :class="{
                            'w-[900px] h-[600px]': previewMode === 'desktop',
                            'w-[600px] h-[800px]': previewMode === 'tablet',
                            'w-[375px] h-[667px]': previewMode === 'mobile'
                        }" class="bg-white rounded-lg shadow-xl dark:bg-neutral-900 relative overflow-hidden transition-all duration-300">
                            
                            <!-- Canvas Content -->
                            <div class="absolute inset-0 p-4">
                                <!-- Sample Welcome Template -->
                                <template x-if="selectedTemplate === 'welcome'">
                                    <div class="h-full flex flex-col">
                                        <!-- Header Section -->
                                        <div @click="selectedComponent = 'header'" :class="selectedComponent === 'header' ? 'ring-2 ring-blue-500' : ''" class="text-center mb-6 p-3 rounded cursor-pointer">
                                            <h1 class="text-3xl font-bold text-gray-800 mb-2">Welcome to Grand Hotel</h1>
                                            <p class="text-base text-gray-600">We hope you enjoy your stay with us</p>
                                        </div>
                                        
                                        <!-- Content Grid -->
                                        <div class="flex-1 grid grid-cols-2 gap-4">
                                            <!-- Weather Widget -->
                                            <div @click="selectedComponent = 'weather'" :class="selectedComponent === 'weather' ? 'ring-2 ring-blue-500' : ''" class="bg-blue-50 p-4 rounded-lg cursor-pointer">
                                                <div class="flex items-center justify-between">
                                                    <div>
                                                        <h3 class="text-lg font-semibold text-blue-800">Weather</h3>
                                                        <p class="text-sm text-blue-600">New York, NY</p>
                                                    </div>
                                                    <div class="text-right">
                                                        <div class="text-2xl font-bold text-blue-800">72°F</div>
                                                        <p class="text-sm text-blue-600">Sunny</p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Hotel Info -->
                                            <div @click="selectedComponent = 'info'" :class="selectedComponent === 'info' ? 'ring-2 ring-blue-500' : ''" class="bg-green-50 p-4 rounded-lg cursor-pointer">
                                                <h3 class="text-lg font-semibold text-green-800 mb-2">Hotel Services</h3>
                                                <ul class="space-y-1 text-sm text-green-700">
                                                    <li>• Restaurant: 6:00 AM - 11:00 PM</li>
                                                    <li>• Spa: 8:00 AM - 9:00 PM</li>
                                                    <li>• Pool: 6:00 AM - 10:00 PM</li>
                                                </ul>
                                            </div>
                                            
                                            <!-- Events -->
                                            <div @click="selectedComponent = 'events'" :class="selectedComponent === 'events' ? 'ring-2 ring-blue-500' : ''" class="bg-purple-50 p-4 rounded-lg cursor-pointer">
                                                <h3 class="text-lg font-semibold text-purple-800 mb-2">Today's Events</h3>
                                                <ul class="space-y-1 text-sm text-purple-700">
                                                    <li>• Wine Tasting - 7:00 PM</li>
                                                    <li>• Live Jazz - 9:00 PM</li>
                                                    <li>• Yoga Class - 7:00 AM</li>
                                                </ul>
                                            </div>
                                            
                                            <!-- QR Code -->
                                            <div @click="selectedComponent = 'qr'" :class="selectedComponent === 'qr' ? 'ring-2 ring-blue-500' : ''" class="bg-gray-50 p-4 rounded-lg cursor-pointer flex flex-col items-center">
                                                <div class="w-16 h-16 bg-black mb-2"></div>
                                                <p class="text-xs text-gray-600 text-center">Scan for WiFi Access</p>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                
                                <!-- Placeholder for other templates -->
                                <template x-if="selectedTemplate !== 'welcome'">
                                    <div class="h-full flex items-center justify-center">
                                        <div class="text-center">
                                            <svg class="mx-auto h-24 w-24 text-neutral-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <flux:text class="text-lg font-medium text-neutral-600 dark:text-neutral-400">Template Preview</flux:text>
                                            <flux:text class="text-sm text-neutral-500 dark:text-neutral-500">Select a component to start editing</flux:text>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Properties Panel -->
            <div x-show="showPropertiesPanel && selectedComponent" class="w-72 border-l border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
                <div class="p-4">
                    <div class="flex items-center justify-between mb-4">
                        <flux:heading size="sm">{{ __('Properties') }}</flux:heading>
                        <button @click="selectedComponent = null" class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="space-y-4">
                        <!-- Component Type -->
                        <div>
                            <flux:text class="text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider mb-2">{{ __('Component Type') }}</flux:text>
                            <div class="p-3 bg-neutral-50 rounded-lg dark:bg-neutral-800">
                                <flux:text class="text-sm font-medium" x-text="selectedComponent === 'header' ? 'Header Section' : selectedComponent === 'weather' ? 'Weather Widget' : selectedComponent === 'info' ? 'Information Block' : selectedComponent === 'events' ? 'Events List' : 'QR Code'"></flux:text>
                            </div>
                        </div>

                        <!-- Content Properties -->
                        <template x-if="selectedComponent === 'header'">
                            <div class="space-y-4">
                                <div>
                                    <flux:text class="text-sm font-medium mb-2 block">{{ __('Title Text') }}</flux:text>
                                    <input type="text" value="Welcome to Grand Hotel" class="w-full rounded-lg border border-neutral-200 bg-white px-3 py-2 text-sm dark:border-neutral-700 dark:bg-neutral-900 dark:text-white">
                                </div>
                                <div>
                                    <flux:text class="text-sm font-medium mb-2 block">{{ __('Subtitle Text') }}</flux:text>
                                    <input type="text" value="We hope you enjoy your stay with us" class="w-full rounded-lg border border-neutral-200 bg-white px-3 py-2 text-sm dark:border-neutral-700 dark:bg-neutral-900 dark:text-white">
                                </div>
                                <div>
                                    <flux:text class="text-sm font-medium mb-2 block">{{ __('Text Color') }}</flux:text>
                                    <input type="color" value="#1f2937" class="w-full h-10 rounded-lg border border-neutral-200 dark:border-neutral-700">
                                </div>
                            </div>
                        </template>

                        <template x-if="selectedComponent === 'weather'">
                            <div class="space-y-4">
                                <div>
                                    <flux:text class="text-sm font-medium mb-2 block">{{ __('Location') }}</flux:text>
                                    <input type="text" value="New York, NY" class="w-full rounded-lg border border-neutral-200 bg-white px-3 py-2 text-sm dark:border-neutral-700 dark:bg-neutral-900 dark:text-white">
                                </div>
                                <div>
                                    <flux:text class="text-sm font-medium mb-2 block">{{ __('Background Color') }}</flux:text>
                                    <input type="color" value="#dbeafe" class="w-full h-10 rounded-lg border border-neutral-200 dark:border-neutral-700">
                                </div>
                                <div>
                                    <flux:text class="text-sm font-medium mb-2 block">{{ __('Show Icon') }}</flux:text>
                                    <label class="flex items-center">
                                        <input type="checkbox" checked class="rounded border-neutral-300 dark:border-neutral-600">
                                        <span class="ml-2 text-sm">{{ __('Display weather icon') }}</span>
                                    </label>
                                </div>
                            </div>
                        </template>

                        <!-- Position & Size -->
                        <div>
                            <flux:text class="text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider mb-2">{{ __('Layout') }}</flux:text>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <flux:text class="text-xs text-neutral-600 dark:text-neutral-400 mb-1">{{ __('Width') }}</flux:text>
                                    <input type="number" value="300" class="w-full rounded border border-neutral-200 px-2 py-1 text-sm dark:border-neutral-700 dark:bg-neutral-900 dark:text-white">
                                </div>
                                <div>
                                    <flux:text class="text-xs text-neutral-600 dark:text-neutral-400 mb-1">{{ __('Height') }}</flux:text>
                                    <input type="number" value="150" class="w-full rounded border border-neutral-200 px-2 py-1 text-sm dark:border-neutral-700 dark:bg-neutral-900 dark:text-white">
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="pt-4 border-t border-neutral-200 dark:border-neutral-700">
                            <div class="flex gap-2">
                                <flux:button variant="subtle" size="sm" class="flex-1">
                                    {{ __('Duplicate') }}
                                </flux:button>
                                <flux:button variant="subtle" size="sm" class="flex-1 text-red-600 dark:text-red-400">
                                    {{ __('Delete') }}
                                </flux:button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Publish Template Modal -->
        <flux:modal name="publish-template-modal" class="max-w-4xl">
            <div class="p-6">
                <div class="mb-6">
                    <flux:heading size="lg">{{ __('Publish Template') }}</flux:heading>
                    <flux:subheading>{{ __('Deploy Welcome Template to selected displays') }}</flux:subheading>
                </div>

                <div class="grid gap-6 lg:grid-cols-2">
                    <!-- Display Selection -->
                    <div>
                        <flux:heading size="base" class="mb-4">{{ __('Select Displays') }}</flux:heading>
                        
                        <!-- Quick Selection Buttons -->
                        <div class="mb-4 flex flex-wrap gap-2">
                            <button class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200 dark:bg-blue-900 dark:text-blue-200">
                                {{ __('All Rooms') }}
                            </button>
                            <button class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 hover:bg-green-200 dark:bg-green-900 dark:text-green-200">
                                {{ __('Public Areas') }}
                            </button>
                            <button class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 hover:bg-purple-200 dark:bg-purple-900 dark:text-purple-200">
                                {{ __('Conference Rooms') }}
                            </button>
                        </div>

                        <!-- Select All -->
                        <div class="mb-4 p-3 bg-neutral-50 rounded-lg dark:bg-neutral-800">
                            <label class="flex items-center">
                                <input type="checkbox" checked class="rounded border-neutral-300 dark:border-neutral-600">
                                <span class="ml-2 text-sm font-medium">{{ __('Select All Online Displays') }}</span>
                                <span class="ml-2 text-xs text-neutral-500">(14 displays)</span>
                            </label>
                        </div>

                        <!-- Display List -->
                        <div class="max-h-80 overflow-y-auto border border-neutral-200 rounded-lg dark:border-neutral-700">
                            <div class="flex items-center justify-between p-3 border-b border-neutral-100 dark:border-neutral-700">
                                <div class="flex items-center">
                                    <input type="checkbox" checked class="rounded border-neutral-300 dark:border-neutral-600">
                                    <div class="ml-3">
                                        <flux:text class="text-sm font-medium">Lobby Main Display</flux:text>
                                        <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">Lobby</flux:text>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    <div class="h-1.5 w-1.5 rounded-full bg-green-400 mr-1"></div>
                                    {{ __('Online') }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between p-3 border-b border-neutral-100 dark:border-neutral-700">
                                <div class="flex items-center">
                                    <input type="checkbox" checked class="rounded border-neutral-300 dark:border-neutral-600">
                                    <div class="ml-3">
                                        <flux:text class="text-sm font-medium">Reception Desk</flux:text>
                                        <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">Reception</flux:text>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    <div class="h-1.5 w-1.5 rounded-full bg-green-400 mr-1"></div>
                                    {{ __('Online') }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between p-3 border-b border-neutral-100 dark:border-neutral-700">
                                <div class="flex items-center">
                                    <input type="checkbox" checked class="rounded border-neutral-300 dark:border-neutral-600">
                                    <div class="ml-3">
                                        <flux:text class="text-sm font-medium">Room 101 TV</flux:text>
                                        <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">Floor 1</flux:text>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    <div class="h-1.5 w-1.5 rounded-full bg-green-400 mr-1"></div>
                                    {{ __('Online') }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between p-3 border-b border-neutral-100 dark:border-neutral-700">
                                <div class="flex items-center">
                                    <input type="checkbox" class="rounded border-neutral-300 dark:border-neutral-600">
                                    <div class="ml-3">
                                        <flux:text class="text-sm font-medium">Room 102 TV</flux:text>
                                        <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">Floor 1</flux:text>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    <div class="h-1.5 w-1.5 rounded-full bg-green-400 mr-1"></div>
                                    {{ __('Online') }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between p-3 border-b border-neutral-100 dark:border-neutral-700 opacity-50">
                                <div class="flex items-center">
                                    <input type="checkbox" disabled class="rounded border-neutral-300 dark:border-neutral-600">
                                    <div class="ml-3">
                                        <flux:text class="text-sm font-medium">Room 103 TV</flux:text>
                                        <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">Floor 1</flux:text>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                    <div class="h-1.5 w-1.5 rounded-full bg-red-400 mr-1"></div>
                                    {{ __('Offline') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Deployment Settings -->
                    <div>
                        <flux:heading size="base" class="mb-4">{{ __('Deployment Settings') }}</flux:heading>
                        
                        <!-- Deployment Type -->
                        <div class="mb-6">
                            <flux:text class="text-sm font-medium mb-3 block">{{ __('When to Deploy') }}</flux:text>
                            <div class="space-y-3">
                                <label class="flex items-center p-3 border border-blue-500 bg-blue-50 rounded-lg cursor-pointer dark:bg-blue-900/20">
                                    <input type="radio" value="immediate" checked class="text-blue-600">
                                    <div class="ml-3">
                                        <flux:text class="text-sm font-medium">{{ __('Deploy Immediately') }}</flux:text>
                                        <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('Template will be deployed right after confirmation') }}</flux:text>
                                    </div>
                                </label>
                                
                                <label class="flex items-center p-3 border border-neutral-200 rounded-lg cursor-pointer hover:bg-neutral-50 dark:border-neutral-700 dark:hover:bg-neutral-800">
                                    <input type="radio" value="scheduled" class="text-blue-600">
                                    <div class="ml-3">
                                        <flux:text class="text-sm font-medium">{{ __('Schedule Deployment') }}</flux:text>
                                        <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('Template will be deployed at a specific date and time') }}</flux:text>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Deployment Summary -->
                        <div class="mt-6 p-4 bg-neutral-50 rounded-lg dark:bg-neutral-800">
                            <flux:text class="text-sm font-medium mb-2 block">{{ __('Deployment Summary') }}</flux:text>
                            <div class="space-y-1 text-sm text-neutral-600 dark:text-neutral-400">
                                <div>{{ __('Template:') }} <span class="font-medium">Welcome Template</span></div>
                                <div>{{ __('Selected Displays:') }} <span class="font-medium">5</span></div>
                                <div>{{ __('Deployment:') }} <span class="font-medium text-green-600">{{ __('Immediate') }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                    <flux:modal.close>
                        <flux:button variant="subtle">{{ __('Cancel') }}</flux:button>
                    </flux:modal.close>
                    <flux:button variant="primary" @click="alert('Template deployment initiated for 5 displays!')">
                        {{ __('Deploy Now') }}
                    </flux:button>
                </div>
            </div>
        </flux:modal>
    </div>
</x-layouts.app>
