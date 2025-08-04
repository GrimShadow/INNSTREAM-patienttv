<x-layouts.app :title="__('Templates')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <!-- Navigation Tabs -->
        <flux:navbar scrollable>
            <flux:navbar.item href="{{ route('template-management') }}" :current="request()->routeIs('template-management')">Overview</flux:navbar.item>
            <flux:navbar.item href="{{ route('template-ui') }}">UI</flux:navbar.item>
            <flux:navbar.item href="{{ route('templates') }}">Templates</flux:navbar.item>
        </flux:navbar>

        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl" level="1">{{ __('Template Gallery') }}</flux:heading>
                <flux:subheading class="mt-1">{{ __('Browse and preview hotel TV display templates') }}</flux:subheading>
            </div>
            <div class="flex items-center gap-3">
                <flux:button variant="filled" icon="funnel">
                    {{ __('Filter') }}
                </flux:button>
                <flux:button variant="primary" icon="plus">
                    {{ __('Create Template') }}
                </flux:button>
            </div>
        </div>

        <!-- Search and Categories -->
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <flux:input placeholder="Search templates..." class="w-64" icon="magnifying-glass" />
                <select class="rounded-lg border border-neutral-200 bg-white px-3 py-2 text-sm dark:border-neutral-700 dark:bg-neutral-900 dark:text-white">
                    <option value="all">{{ __('All Categories') }}</option>
                    <option value="welcome">{{ __('Welcome Screens') }}</option>
                    <option value="info">{{ __('Hotel Information') }}</option>
                    <option value="dining">{{ __('Dining & Events') }}</option>
                    <option value="weather">{{ __('Weather & News') }}</option>
                    <option value="entertainment">{{ __('Entertainment') }}</option>
                </select>
            </div>
            <div class="flex items-center gap-2">
                <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('24 templates') }}</flux:text>
            </div>
        </div>

        <!-- Template Grid -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <!-- Welcome Template Card -->
            <div class="group cursor-pointer overflow-hidden rounded-xl border border-neutral-200 bg-white transition-all hover:shadow-lg dark:border-neutral-700 dark:bg-neutral-900" 
                 onclick="openTemplateModal('welcome')">
                <div class="relative aspect-video overflow-hidden bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-blue-950 dark:to-indigo-900">
                    <!-- Mock TV Screen Preview -->
                    <div class="absolute inset-4 rounded-lg bg-black p-6 text-white">
                        <div class="flex h-full flex-col justify-between">
                            <div>
                                <flux:heading size="lg" class="text-white">{{ __('Welcome to Grand Hotel') }}</flux:heading>
                                <flux:text class="mt-2 text-neutral-300">{{ __('Your comfort is our priority') }}</flux:text>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="text-xs text-neutral-400">
                                    <div>{{ __('Room 301') }}</div>
                                    <div>{{ __('March 15, 2024') }}</div>
                                </div>
                                <div class="text-right text-xs text-neutral-400">
                                    <div>{{ __('Check-out: 11:00 AM') }}</div>
                                    <div>{{ __('Wi-Fi: GrandHotel_Guest') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Hover Overlay -->
                    <div class="absolute inset-0 bg-black/20 opacity-0 transition-opacity group-hover:opacity-100"></div>
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 transition-opacity group-hover:opacity-100">
                        <flux:button variant="primary" size="sm" icon="eye">
                            {{ __('Preview') }}
                        </flux:button>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <flux:heading size="base">{{ __('Welcome Screen') }}</flux:heading>
                            <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Guest greeting template') }}</flux:text>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="rounded-full bg-green-100 px-2 py-1 text-xs text-green-800 dark:bg-green-900 dark:text-green-200">{{ __('Popular') }}</span>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center justify-between">
                        <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('Used in 156 displays') }}</flux:text>
                        <div class="flex items-center space-x-1">
                            <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <flux:text class="text-xs">4.8</flux:text>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hotel Information Template Card -->
            <div class="group cursor-pointer overflow-hidden rounded-xl border border-neutral-200 bg-white transition-all hover:shadow-lg dark:border-neutral-700 dark:bg-neutral-900"
                 onclick="openTemplateModal('info')">
                <div class="relative aspect-video overflow-hidden bg-gradient-to-br from-emerald-50 to-teal-100 dark:from-emerald-950 dark:to-teal-900">
                    <div class="absolute inset-4 rounded-lg bg-black p-6 text-white">
                        <div class="grid h-full grid-cols-2 gap-4">
                            <div>
                                <flux:heading size="sm" class="text-white">{{ __('Hotel Services') }}</flux:heading>
                                <div class="mt-2 space-y-1 text-xs text-neutral-300">
                                    <div>🍽️ Restaurant: 6AM-11PM</div>
                                    <div>🏊 Pool: 6AM-10PM</div>
                                    <div>💼 Business Center: 24/7</div>
                                    <div>🚗 Valet Parking Available</div>
                                </div>
                            </div>
                            <div>
                                <flux:heading size="sm" class="text-white">{{ __('Local Weather') }}</flux:heading>
                                <div class="mt-2 text-xs text-neutral-300">
                                    <div>☀️ 72°F Sunny</div>
                                    <div>💨 Light breeze</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-black/20 opacity-0 transition-opacity group-hover:opacity-100"></div>
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 transition-opacity group-hover:opacity-100">
                        <flux:button variant="primary" size="sm" icon="eye">
                            {{ __('Preview') }}
                        </flux:button>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <flux:heading size="base">{{ __('Hotel Information') }}</flux:heading>
                            <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Services & amenities') }}</flux:text>
                        </div>
                        <span class="rounded-full bg-blue-100 px-2 py-1 text-xs text-blue-800 dark:bg-blue-900 dark:text-blue-200">{{ __('Updated') }}</span>
                    </div>
                    <div class="mt-3 flex items-center justify-between">
                        <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('Used in 89 displays') }}</flux:text>
                        <div class="flex items-center space-x-1">
                            <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <flux:text class="text-xs">4.6</flux:text>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dining & Events Template Card -->
            <div class="group cursor-pointer overflow-hidden rounded-xl border border-neutral-200 bg-white transition-all hover:shadow-lg dark:border-neutral-700 dark:bg-neutral-900"
                 onclick="openTemplateModal('dining')">
                <div class="relative aspect-video overflow-hidden bg-gradient-to-br from-orange-50 to-red-100 dark:from-orange-950 dark:to-red-900">
                    <div class="absolute inset-4 rounded-lg bg-black p-6 text-white">
                        <div class="flex h-full flex-col">
                            <flux:heading size="sm" class="text-white">{{ __('Today\'s Specials') }}</flux:heading>
                            <div class="mt-2 flex-1 space-y-2 text-xs text-neutral-300">
                                <div>🥩 Grilled Salmon - $28</div>
                                <div>🍝 Truffle Pasta - $24</div>
                                <div>🍷 Wine Pairing Available</div>
                            </div>
                            <div class="mt-auto">
                                <flux:text class="text-xs text-neutral-400">{{ __('Reservations: Ext. 7') }}</flux:text>
                            </div>
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-black/20 opacity-0 transition-opacity group-hover:opacity-100"></div>
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 transition-opacity group-hover:opacity-100">
                        <flux:button variant="primary" size="sm" icon="eye">
                            {{ __('Preview') }}
                        </flux:button>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <flux:heading size="base">{{ __('Dining & Events') }}</flux:heading>
                            <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Restaurant & activities') }}</flux:text>
                        </div>
                        <span class="rounded-full bg-purple-100 px-2 py-1 text-xs text-purple-800 dark:bg-purple-900 dark:text-purple-200">{{ __('Premium') }}</span>
                    </div>
                    <div class="mt-3 flex items-center justify-between">
                        <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('Used in 42 displays') }}</flux:text>
                        <div class="flex items-center space-x-1">
                            <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <flux:text class="text-xs">4.9</flux:text>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Weather Template Card -->
            <div class="group cursor-pointer overflow-hidden rounded-xl border border-neutral-200 bg-white transition-all hover:shadow-lg dark:border-neutral-700 dark:bg-neutral-900"
                 onclick="openTemplateModal('weather')">
                <div class="relative aspect-video overflow-hidden bg-gradient-to-br from-sky-50 to-blue-100 dark:from-sky-950 dark:to-blue-900">
                    <div class="absolute inset-4 rounded-lg bg-black p-6 text-white">
                        <div class="grid h-full grid-cols-2 gap-4">
                            <div>
                                <flux:heading size="sm" class="text-white">{{ __('Today') }}</flux:heading>
                                <div class="mt-2 text-neutral-300">
                                    <div class="text-2xl">☀️</div>
                                    <div class="text-lg">72°F</div>
                                    <div class="text-xs">Sunny</div>
                                </div>
                            </div>
                            <div>
                                <flux:heading size="sm" class="text-white">{{ __('This Week') }}</flux:heading>
                                <div class="mt-2 space-y-1 text-xs text-neutral-300">
                                    <div>Wed ⛅ 68°F</div>
                                    <div>Thu 🌧️ 65°F</div>
                                    <div>Fri ☀️ 75°F</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-black/20 opacity-0 transition-opacity group-hover:opacity-100"></div>
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 transition-opacity group-hover:opacity-100">
                        <flux:button variant="primary" size="sm" icon="eye">
                            {{ __('Preview') }}
                        </flux:button>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <flux:heading size="base">{{ __('Weather Display') }}</flux:heading>
                            <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Local weather & forecast') }}</flux:text>
                        </div>
                        <span class="rounded-full bg-yellow-100 px-2 py-1 text-xs text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">{{ __('Live Data') }}</span>
                    </div>
                    <div class="mt-3 flex items-center justify-between">
                        <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('Used in 78 displays') }}</flux:text>
                        <div class="flex items-center space-x-1">
                            <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <flux:text class="text-xs">4.7</flux:text>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Entertainment Template Card -->
            <div class="group cursor-pointer overflow-hidden rounded-xl border border-neutral-200 bg-white transition-all hover:shadow-lg dark:border-neutral-700 dark:bg-neutral-900"
                 onclick="openTemplateModal('entertainment')">
                <div class="relative aspect-video overflow-hidden bg-gradient-to-br from-violet-50 to-purple-100 dark:from-violet-950 dark:to-purple-900">
                    <div class="absolute inset-4 rounded-lg bg-black p-6 text-white">
                        <div class="flex h-full flex-col">
                            <flux:heading size="sm" class="text-white">{{ __('Entertainment Guide') }}</flux:heading>
                            <div class="mt-2 flex-1 space-y-2 text-xs text-neutral-300">
                                <div>📺 HBO Max • Netflix • Disney+</div>
                                <div>🎵 Spotify Premium Available</div>
                                <div>🎮 Gaming Console in Room 505</div>
                            </div>
                            <div class="mt-auto">
                                <flux:text class="text-xs text-neutral-400">{{ __('Voice Control: "Hey Hotel"') }}</flux:text>
                            </div>
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-black/20 opacity-0 transition-opacity group-hover:opacity-100"></div>
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 transition-opacity group-hover:opacity-100">
                        <flux:button variant="primary" size="sm" icon="eye">
                            {{ __('Preview') }}
                        </flux:button>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <flux:heading size="base">{{ __('Entertainment Hub') }}</flux:heading>
                            <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Streaming & media guide') }}</flux:text>
                        </div>
                        <span class="rounded-full bg-indigo-100 px-2 py-1 text-xs text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">{{ __('Interactive') }}</span>
                    </div>
                    <div class="mt-3 flex items-center justify-between">
                        <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('Used in 134 displays') }}</flux:text>
                        <div class="flex items-center space-x-1">
                            <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <flux:text class="text-xs">4.5</flux:text>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Minimalist Template Card -->
            <div class="group cursor-pointer overflow-hidden rounded-xl border border-neutral-200 bg-white transition-all hover:shadow-lg dark:border-neutral-700 dark:bg-neutral-900"
                 onclick="openTemplateModal('minimal')">
                <div class="relative aspect-video overflow-hidden bg-gradient-to-br from-gray-50 to-neutral-100 dark:from-gray-950 dark:to-neutral-900">
                    <div class="absolute inset-4 rounded-lg bg-black p-6 text-white">
                        <div class="flex h-full items-center justify-center">
                            <div class="text-center">
                                <flux:heading size="lg" class="text-white">{{ __('Welcome') }}</flux:heading>
                                <flux:text class="mt-2 text-neutral-300">{{ __('Room 301') }}</flux:text>
                                <div class="mt-4 text-xs text-neutral-400">
                                    <div>{{ __('March 15, 2024') }}</div>
                                    <div>{{ __('11:30 AM') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-black/20 opacity-0 transition-opacity group-hover:opacity-100"></div>
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 transition-opacity group-hover:opacity-100">
                        <flux:button variant="primary" size="sm" icon="eye">
                            {{ __('Preview') }}
                        </flux:button>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <flux:heading size="base">{{ __('Minimalist') }}</flux:heading>
                            <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Clean & simple design') }}</flux:text>
                        </div>
                        <span class="rounded-full bg-gray-100 px-2 py-1 text-xs text-gray-800 dark:bg-gray-800 dark:text-gray-200">{{ __('Classic') }}</span>
                    </div>
                    <div class="mt-3 flex items-center justify-between">
                        <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('Used in 67 displays') }}</flux:text>
                        <div class="flex items-center space-x-1">
                            <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <flux:text class="text-xs">4.4</flux:text>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Load More Button -->
        <div class="flex justify-center">
            <flux:button variant="filled" class="px-8">
                {{ __('Load More Templates') }}
            </flux:button>
        </div>
    </div>

    <!-- Template Preview Modal -->
    <flux:modal name="template-preview" class="max-w-4xl">
        <div class="p-6">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <flux:heading size="lg" id="modal-title">{{ __('Template Preview') }}</flux:heading>
                    <flux:subheading id="modal-subtitle">{{ __('Template details and preview') }}</flux:subheading>
                </div>
                <div class="flex items-center gap-3">
                    <flux:button variant="filled" icon="pencil-square">
                        {{ __('Customize') }}
                    </flux:button>
                    <flux:button variant="primary" icon="plus">
                        {{ __('Use Template') }}
                    </flux:button>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <!-- Preview Area -->
                <div class="aspect-video overflow-hidden rounded-xl border border-neutral-200 bg-black dark:border-neutral-700">
                    <div id="template-preview-content" class="h-full w-full p-6 text-white">
                        <!-- Content will be dynamically inserted here -->
                    </div>
                </div>

                <!-- Template Details -->
                <div class="space-y-6">
                    <div>
                        <flux:heading size="base">{{ __('Template Features') }}</flux:heading>
                        <div id="template-features" class="mt-2 space-y-2">
                            <!-- Features will be dynamically inserted here -->
                        </div>
                    </div>

                    <div>
                        <flux:heading size="base">{{ __('Usage Statistics') }}</flux:heading>
                        <div class="mt-2 grid grid-cols-2 gap-4">
                            <div class="rounded-lg border border-neutral-200 p-3 dark:border-neutral-700">
                                <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Active Displays') }}</flux:text>
                                <flux:heading size="lg" id="usage-count">156</flux:heading>
                            </div>
                            <div class="rounded-lg border border-neutral-200 p-3 dark:border-neutral-700">
                                <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('User Rating') }}</flux:text>
                                <div class="flex items-center space-x-1">
                                    <flux:heading size="lg" id="rating">4.8</flux:heading>
                                    <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <flux:heading size="base">{{ __('Compatible Displays') }}</flux:heading>
                        <div class="mt-2 space-y-2 text-sm text-neutral-600 dark:text-neutral-300">
                            <div class="flex items-center space-x-2">
                                <svg class="h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ __('Samsung Smart TVs') }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg class="h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ __('LG WebOS Displays') }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg class="h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ __('Sony Professional Displays') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                <flux:modal.close>
                    <flux:button variant="subtle">{{ __('Close') }}</flux:button>
                </flux:modal.close>
                <flux:button variant="primary">{{ __('Apply to Displays') }}</flux:button>
            </div>
        </div>
    </flux:modal>

    <script>
        function openTemplateModal(templateType) {
            // This would typically make an API call to get template details
            // For now, we'll use static data
            
            const templates = {
                welcome: {
                    title: 'Welcome Screen Template',
                    subtitle: 'Guest greeting and room information',
                    features: [
                        'Personalized guest welcome message',
                        'Room number and check-out time display',
                        'Hotel Wi-Fi credentials',
                        'Dynamic date and time',
                        'Customizable hotel branding'
                    ],
                    usage: 156,
                    rating: 4.8
                },
                info: {
                    title: 'Hotel Information Template',
                    subtitle: 'Services, amenities, and local information',
                    features: [
                        'Hotel services and hours',
                        'Local weather integration',
                        'Amenity information and locations',
                        'Contact information for services',
                        'Real-time updates'
                    ],
                    usage: 89,
                    rating: 4.6
                }
                // Add more templates as needed
            };
            
            const template = templates[templateType] || templates.welcome;
            
            // Update modal content
            document.getElementById('modal-title').textContent = template.title;
            document.getElementById('modal-subtitle').textContent = template.subtitle;
            document.getElementById('usage-count').textContent = template.usage;
            document.getElementById('rating').textContent = template.rating;
            
            // Update features list
            const featuresContainer = document.getElementById('template-features');
            featuresContainer.innerHTML = template.features.map(feature => 
                `<div class="flex items-start space-x-2">
                    <svg class="h-4 w-4 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm">${feature}</span>
                </div>`
            ).join('');
            
            // Open modal (this depends on your modal implementation)
            // For Flux UI, this might be something like:
            window.dispatchEvent(new CustomEvent('modal:open', { detail: { name: 'template-preview' } }));
        }
    </script>
</x-layouts.app>
