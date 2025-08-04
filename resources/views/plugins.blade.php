<x-layouts.app :title="__('Plugin Store')">

    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-neutral-900 dark:text-white">{{ __('Plugin Store') }}</h1>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('Browse and install plugins to enhance your hotel and hospital IPTV system') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <flux:button variant="outline" size="sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"></path>
                    </svg>
                    {{ __('Filter') }}
                </flux:button>
                <flux:button variant="outline" size="sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    {{ __('Search') }}
                </flux:button>
            </div>
        </div>

        <!-- Plugin Grid -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            <!-- Plugin 1: Guest Information Portal -->
            <div class="group relative overflow-hidden rounded-xl border border-neutral-200 bg-white transition-all duration-200 hover:shadow-lg dark:border-neutral-700 dark:bg-neutral-900">
                <div class="aspect-video bg-gradient-to-br from-blue-500 to-purple-600 p-4">
                    <div class="flex h-full items-center justify-center">
                        <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-neutral-900 dark:text-white">Guest Information Portal</h3>
                            <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">Hotel amenities, services, and local information</p>
                        </div>
                        <span class="ml-2 rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-800 dark:bg-green-900/20 dark:text-green-400">Free</span>
                    </div>
                    <div class="mt-3 flex items-center justify-between">
                        <div class="flex items-center text-sm text-neutral-500 dark:text-neutral-400">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            4.8 (2.1k)
                        </div>
                        <flux:button size="sm">Install</flux:button>
                    </div>
                </div>
            </div>

            <!-- Plugin 2: Patient Information System -->
            <div class="group relative overflow-hidden rounded-xl border border-neutral-200 bg-white transition-all duration-200 hover:shadow-lg dark:border-neutral-700 dark:bg-neutral-900">
                <div class="aspect-video bg-gradient-to-br from-green-500 to-teal-600 p-4">
                    <div class="flex h-full items-center justify-center">
                        <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-neutral-900 dark:text-white">Patient Information System</h3>
                            <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">Patient care information and updates</p>
                        </div>
                        <span class="ml-2 rounded-full bg-blue-100 px-2 py-1 text-xs font-medium text-blue-800 dark:bg-blue-900/20 dark:text-blue-400">$49</span>
                    </div>
                    <div class="mt-3 flex items-center justify-between">
                        <div class="flex items-center text-sm text-neutral-500 dark:text-neutral-400">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            4.6 (856)
                        </div>
                        <flux:button size="sm">Install</flux:button>
                    </div>
                </div>
            </div>

            <!-- Plugin 3: TV Games Suite -->
            <div class="group relative overflow-hidden rounded-xl border border-neutral-200 bg-white transition-all duration-200 hover:shadow-lg dark:border-neutral-700 dark:bg-neutral-900">
                <div class="aspect-video bg-gradient-to-br from-purple-500 to-pink-600 p-4">
                    <div class="flex h-full items-center justify-center">
                        <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-neutral-900 dark:text-white">TV Games Suite</h3>
                            <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">Interactive games for entertainment</p>
                        </div>
                        <span class="ml-2 rounded-full bg-blue-100 px-2 py-1 text-xs font-medium text-blue-800 dark:bg-blue-900/20 dark:text-blue-400">$29</span>
                    </div>
                    <div class="mt-3 flex items-center justify-between">
                        <div class="flex items-center text-sm text-neutral-500 dark:text-neutral-400">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            4.9 (1.5k)
                        </div>
                        <flux:button size="sm">Install</flux:button>
                    </div>
                </div>
            </div>

            <!-- Plugin 4: Outlook Calendar Integration -->
            <div class="group relative overflow-hidden rounded-xl border border-neutral-200 bg-white transition-all duration-200 hover:shadow-lg dark:border-neutral-700 dark:bg-neutral-900">
                <div class="aspect-video bg-gradient-to-br from-red-500 to-orange-600 p-4">
                    <div class="flex h-full items-center justify-center">
                        <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-neutral-900 dark:text-white">Outlook Calendar Integration</h3>
                            <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">Sync meetings and appointments</p>
                        </div>
                        <span class="ml-2 rounded-full bg-blue-100 px-2 py-1 text-xs font-medium text-blue-800 dark:bg-blue-900/20 dark:text-blue-400">$39</span>
                    </div>
                    <div class="mt-3 flex items-center justify-between">
                        <div class="flex items-center text-sm text-neutral-500 dark:text-neutral-400">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            4.7 (623)
                        </div>
                        <flux:button size="sm">Install</flux:button>
                    </div>
                </div>
            </div>

            <!-- Plugin 5: Room Service Menu -->
            <div class="group relative overflow-hidden rounded-xl border border-neutral-200 bg-white transition-all duration-200 hover:shadow-lg dark:border-neutral-700 dark:bg-neutral-900">
                <div class="aspect-video bg-gradient-to-br from-indigo-500 to-blue-600 p-4">
                    <div class="flex h-full items-center justify-center">
                        <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-neutral-900 dark:text-white">Room Service Menu</h3>
                            <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">Digital menu and ordering system</p>
                        </div>
                        <span class="ml-2 rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-800 dark:bg-green-900/20 dark:text-green-400">Free</span>
                    </div>
                    <div class="mt-3 flex items-center justify-between">
                        <div class="flex items-center text-sm text-neutral-500 dark:text-neutral-400">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            4.5 (432)
                        </div>
                        <flux:button size="sm">Install</flux:button>
                    </div>
                </div>
            </div>

            <!-- Plugin 6: Medical Records Viewer -->
            <div class="group relative overflow-hidden rounded-xl border border-neutral-200 bg-white transition-all duration-200 hover:shadow-lg dark:border-neutral-700 dark:bg-neutral-900">
                <div class="aspect-video bg-gradient-to-br from-yellow-500 to-orange-600 p-4">
                    <div class="flex h-full items-center justify-center">
                        <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-neutral-900 dark:text-white">Medical Records Viewer</h3>
                            <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">Secure medical records access</p>
                        </div>
                        <span class="ml-2 rounded-full bg-blue-100 px-2 py-1 text-xs font-medium text-blue-800 dark:bg-blue-900/20 dark:text-blue-400">$79</span>
                    </div>
                    <div class="mt-3 flex items-center justify-between">
                        <div class="flex items-center text-sm text-neutral-500 dark:text-neutral-400">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            4.4 (789)
                        </div>
                        <flux:button size="sm">Install</flux:button>
                    </div>
                </div>
            </div>

            <!-- Plugin 7: Hotel Concierge -->
            <div class="group relative overflow-hidden rounded-xl border border-neutral-200 bg-white transition-all duration-200 hover:shadow-lg dark:border-neutral-700 dark:bg-neutral-900">
                <div class="aspect-video bg-gradient-to-br from-pink-500 to-rose-600 p-4">
                    <div class="flex h-full items-center justify-center">
                        <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-neutral-900 dark:text-white">Hotel Concierge</h3>
                            <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">24/7 concierge services and requests</p>
                        </div>
                        <span class="ml-2 rounded-full bg-blue-100 px-2 py-1 text-xs font-medium text-blue-800 dark:bg-blue-900/20 dark:text-blue-400">$25</span>
                    </div>
                    <div class="mt-3 flex items-center justify-between">
                        <div class="flex items-center text-sm text-neutral-500 dark:text-neutral-400">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            4.8 (1.2k)
                        </div>
                        <flux:button size="sm">Install</flux:button>
                    </div>
                </div>
            </div>

            <!-- Plugin 8: Emergency Alerts -->
            <div class="group relative overflow-hidden rounded-xl border border-neutral-200 bg-white transition-all duration-200 hover:shadow-lg dark:border-neutral-700 dark:bg-neutral-900">
                <div class="aspect-video bg-gradient-to-br from-cyan-500 to-blue-600 p-4">
                    <div class="flex h-full items-center justify-center">
                        <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-neutral-900 dark:text-white">Emergency Alerts</h3>
                            <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">Critical notifications and alerts</p>
                        </div>
                        <span class="ml-2 rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-800 dark:bg-green-900/20 dark:text-green-400">Free</span>
                    </div>
                    <div class="mt-3 flex items-center justify-between">
                        <div class="flex items-center text-sm text-neutral-500 dark:text-neutral-400">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            4.3 (567)
                        </div>
                        <flux:button size="sm">Install</flux:button>
                    </div>
                </div>
            </div>

            <!-- Plugin 9: Local Attractions Guide -->
            <div class="group relative overflow-hidden rounded-xl border border-neutral-200 bg-white transition-all duration-200 hover:shadow-lg dark:border-neutral-700 dark:bg-neutral-900">
                <div class="aspect-video bg-gradient-to-br from-emerald-500 to-green-600 p-4">
                    <div class="flex h-full items-center justify-center">
                        <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-neutral-900 dark:text-white">Local Attractions Guide</h3>
                            <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">Nearby restaurants, attractions, and events</p>
                        </div>
                        <span class="ml-2 rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-800 dark:bg-green-900/20 dark:text-green-400">Free</span>
                    </div>
                    <div class="mt-3 flex items-center justify-between">
                        <div class="flex items-center text-sm text-neutral-500 dark:text-neutral-400">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            4.6 (934)
                        </div>
                        <flux:button size="sm">Install</flux:button>
                    </div>
                </div>
            </div>

            <!-- Plugin 10: Staff Communication Hub -->
            <div class="group relative overflow-hidden rounded-xl border border-neutral-200 bg-white transition-all duration-200 hover:shadow-lg dark:border-neutral-700 dark:bg-neutral-900">
                <div class="aspect-video bg-gradient-to-br from-violet-500 to-purple-600 p-4">
                    <div class="flex h-full items-center justify-center">
                        <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-neutral-900 dark:text-white">Staff Communication Hub</h3>
                            <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">Internal messaging and announcements</p>
                        </div>
                        <span class="ml-2 rounded-full bg-blue-100 px-2 py-1 text-xs font-medium text-blue-800 dark:bg-blue-900/20 dark:text-blue-400">$35</span>
                    </div>
                    <div class="mt-3 flex items-center justify-between">
                        <div class="flex items-center text-sm text-neutral-500 dark:text-neutral-400">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            4.7 (678)
                        </div>
                        <flux:button size="sm">Install</flux:button>
                    </div>
                </div>
            </div>

            <!-- Plugin 11: Billing & Payment Portal -->
            <div class="group relative overflow-hidden rounded-xl border border-neutral-200 bg-white transition-all duration-200 hover:shadow-lg dark:border-neutral-700 dark:bg-neutral-900">
                <div class="aspect-video bg-gradient-to-br from-amber-500 to-yellow-600 p-4">
                    <div class="flex h-full items-center justify-center">
                        <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-neutral-900 dark:text-white">Billing & Payment Portal</h3>
                            <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">Secure billing and payment processing</p>
                        </div>
                        <span class="ml-2 rounded-full bg-blue-100 px-2 py-1 text-xs font-medium text-blue-800 dark:bg-blue-900/20 dark:text-blue-400">$59</span>
                    </div>
                    <div class="mt-3 flex items-center justify-between">
                        <div class="flex items-center text-sm text-neutral-500 dark:text-neutral-400">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            4.5 (445)
                        </div>
                        <flux:button size="sm">Install</flux:button>
            </div>
        </div>
            </div>

            <!-- Plugin 12: Wellness & Entertainment -->
            <div class="group relative overflow-hidden rounded-xl border border-neutral-200 bg-white transition-all duration-200 hover:shadow-lg dark:border-neutral-700 dark:bg-neutral-900">
                <div class="aspect-video bg-gradient-to-br from-slate-500 to-gray-600 p-4">
                    <div class="flex h-full items-center justify-center">
                        <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-neutral-900 dark:text-white">Wellness & Entertainment</h3>
                            <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">Meditation, music, and relaxation content</p>
                        </div>
                        <span class="ml-2 rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-800 dark:bg-green-900/20 dark:text-green-400">Free</span>
                    </div>
                    <div class="mt-3 flex items-center justify-between">
                        <div class="flex items-center text-sm text-neutral-500 dark:text-neutral-400">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            4.2 (321)
                        </div>
                        <flux:button size="sm">Install</flux:button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
