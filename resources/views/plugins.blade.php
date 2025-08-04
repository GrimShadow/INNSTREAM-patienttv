<x-layouts.app :title="__('Plugin Store')">

    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-neutral-900 dark:text-white">{{ __('Plugin Store') }}</h1>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('Browse and install plugins to enhance your IPTV system') }}</p>
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
            <!-- Plugin 1: Analytics Dashboard -->
            <div class="group relative overflow-hidden rounded-xl border border-neutral-200 bg-white transition-all duration-200 hover:shadow-lg dark:border-neutral-700 dark:bg-neutral-900">
                <div class="aspect-video bg-gradient-to-br from-blue-500 to-purple-600 p-4">
                    <div class="flex h-full items-center justify-center">
                        <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-neutral-900 dark:text-white">Analytics Dashboard</h3>
                            <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">Advanced viewer analytics and insights</p>
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

            <!-- Plugin 2: EPG Manager -->
            <div class="group relative overflow-hidden rounded-xl border border-neutral-200 bg-white transition-all duration-200 hover:shadow-lg dark:border-neutral-700 dark:bg-neutral-900">
                <div class="aspect-video bg-gradient-to-br from-green-500 to-teal-600 p-4">
                    <div class="flex h-full items-center justify-center">
                        <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-neutral-900 dark:text-white">EPG Manager</h3>
                            <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">Electronic Program Guide management</p>
                        </div>
                        <span class="ml-2 rounded-full bg-blue-100 px-2 py-1 text-xs font-medium text-blue-800 dark:bg-blue-900/20 dark:text-blue-400">$29</span>
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

            <!-- Plugin 3: Multi-Screen Support -->
            <div class="group relative overflow-hidden rounded-xl border border-neutral-200 bg-white transition-all duration-200 hover:shadow-lg dark:border-neutral-700 dark:bg-neutral-900">
                <div class="aspect-video bg-gradient-to-br from-purple-500 to-pink-600 p-4">
                    <div class="flex h-full items-center justify-center">
                        <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-neutral-900 dark:text-white">Multi-Screen Support</h3>
                            <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">Support for multiple displays</p>
                        </div>
                        <span class="ml-2 rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-800 dark:bg-green-900/20 dark:text-green-400">Free</span>
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

            <!-- Plugin 4: Content Filter -->
            <div class="group relative overflow-hidden rounded-xl border border-neutral-200 bg-white transition-all duration-200 hover:shadow-lg dark:border-neutral-700 dark:bg-neutral-900">
                <div class="aspect-video bg-gradient-to-br from-red-500 to-orange-600 p-4">
                    <div class="flex h-full items-center justify-center">
                        <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-neutral-900 dark:text-white">Content Filter</h3>
                            <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">Advanced content filtering system</p>
                        </div>
                        <span class="ml-2 rounded-full bg-blue-100 px-2 py-1 text-xs font-medium text-blue-800 dark:bg-blue-900/20 dark:text-blue-400">$19</span>
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

            <!-- Plugin 5: Backup Manager -->
            <div class="group relative overflow-hidden rounded-xl border border-neutral-200 bg-white transition-all duration-200 hover:shadow-lg dark:border-neutral-700 dark:bg-neutral-900">
                <div class="aspect-video bg-gradient-to-br from-indigo-500 to-blue-600 p-4">
                    <div class="flex h-full items-center justify-center">
                        <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-neutral-900 dark:text-white">Backup Manager</h3>
                            <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">Automated backup and restore</p>
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

            <!-- Plugin 6: User Management -->
            <div class="group relative overflow-hidden rounded-xl border border-neutral-200 bg-white transition-all duration-200 hover:shadow-lg dark:border-neutral-700 dark:bg-neutral-900">
                <div class="aspect-video bg-gradient-to-br from-yellow-500 to-orange-600 p-4">
                    <div class="flex h-full items-center justify-center">
                        <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-neutral-900 dark:text-white">User Management</h3>
                            <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">Advanced user roles and permissions</p>
                        </div>
                        <span class="ml-2 rounded-full bg-blue-100 px-2 py-1 text-xs font-medium text-blue-800 dark:bg-blue-900/20 dark:text-blue-400">$39</span>
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

            <!-- Plugin 7: Recording Studio -->
            <div class="group relative overflow-hidden rounded-xl border border-neutral-200 bg-white transition-all duration-200 hover:shadow-lg dark:border-neutral-700 dark:bg-neutral-900">
                <div class="aspect-video bg-gradient-to-br from-pink-500 to-rose-600 p-4">
                    <div class="flex h-full items-center justify-center">
                        <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-neutral-900 dark:text-white">Recording Studio</h3>
                            <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">DVR and recording capabilities</p>
                        </div>
                        <span class="ml-2 rounded-full bg-blue-100 px-2 py-1 text-xs font-medium text-blue-800 dark:bg-blue-900/20 dark:text-blue-400">$49</span>
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

            <!-- Plugin 8: Weather Widget -->
            <div class="group relative overflow-hidden rounded-xl border border-neutral-200 bg-white transition-all duration-200 hover:shadow-lg dark:border-neutral-700 dark:bg-neutral-900">
                <div class="aspect-video bg-gradient-to-br from-cyan-500 to-blue-600 p-4">
                    <div class="flex h-full items-center justify-center">
                        <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-neutral-900 dark:text-white">Weather Widget</h3>
                            <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">Local weather information</p>
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

            <!-- Plugin 9: Notification Center -->
            <div class="group relative overflow-hidden rounded-xl border border-neutral-200 bg-white transition-all duration-200 hover:shadow-lg dark:border-neutral-700 dark:bg-neutral-900">
                <div class="aspect-video bg-gradient-to-br from-emerald-500 to-green-600 p-4">
                    <div class="flex h-full items-center justify-center">
                        <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.19 4.19A2 2 0 006 3h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-neutral-900 dark:text-white">Notification Center</h3>
                            <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">System notifications and alerts</p>
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

            <!-- Plugin 10: API Gateway -->
            <div class="group relative overflow-hidden rounded-xl border border-neutral-200 bg-white transition-all duration-200 hover:shadow-lg dark:border-neutral-700 dark:bg-neutral-900">
                <div class="aspect-video bg-gradient-to-br from-violet-500 to-purple-600 p-4">
                    <div class="flex h-full items-center justify-center">
                        <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-neutral-900 dark:text-white">API Gateway</h3>
                            <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">RESTful API management</p>
                        </div>
                        <span class="ml-2 rounded-full bg-blue-100 px-2 py-1 text-xs font-medium text-blue-800 dark:bg-blue-900/20 dark:text-blue-400">$79</span>
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

            <!-- Plugin 11: Performance Monitor -->
            <div class="group relative overflow-hidden rounded-xl border border-neutral-200 bg-white transition-all duration-200 hover:shadow-lg dark:border-neutral-700 dark:bg-neutral-900">
                <div class="aspect-video bg-gradient-to-br from-amber-500 to-yellow-600 p-4">
                    <div class="flex h-full items-center justify-center">
                        <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-neutral-900 dark:text-white">Performance Monitor</h3>
                            <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">System performance tracking</p>
                        </div>
                        <span class="ml-2 rounded-full bg-blue-100 px-2 py-1 text-xs font-medium text-blue-800 dark:bg-blue-900/20 dark:text-blue-400">$25</span>
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

            <!-- Plugin 12: Custom Themes -->
            <div class="group relative overflow-hidden rounded-xl border border-neutral-200 bg-white transition-all duration-200 hover:shadow-lg dark:border-neutral-700 dark:bg-neutral-900">
                <div class="aspect-video bg-gradient-to-br from-slate-500 to-gray-600 p-4">
                    <div class="flex h-full items-center justify-center">
                        <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-neutral-900 dark:text-white">Custom Themes</h3>
                            <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">Customizable UI themes</p>
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
