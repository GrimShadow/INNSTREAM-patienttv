<x-layouts.app :title="__('Display Management')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <flux:button variant="filled" icon="arrow-path" class="bg-blue-600 hover:bg-blue-700">
                    {{ __('Refresh All') }}
                </flux:button>
                <flux:button variant="primary" icon="plus">
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
                        <flux:heading size="lg" class="mt-1 text-green-600 dark:text-green-400">247</flux:heading>
                    </div>
                    <div class="h-2 w-2 rounded-full bg-green-500"></div>
                </div>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:subheading class="text-neutral-500 dark:text-neutral-400">{{ __('Offline') }}</flux:subheading>
                        <flux:heading size="lg" class="mt-1 text-red-600 dark:text-red-400">12</flux:heading>
                    </div>
                    <div class="h-2 w-2 rounded-full bg-red-500"></div>
                </div>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:subheading class="text-neutral-500 dark:text-neutral-400">{{ __('Powered Off') }}</flux:subheading>
                        <flux:heading size="lg" class="mt-1 text-yellow-600 dark:text-yellow-400">21</flux:heading>
                    </div>
                    <div class="h-2 w-2 rounded-full bg-yellow-500"></div>
                </div>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:subheading class="text-neutral-500 dark:text-neutral-400">{{ __('Total') }}</flux:subheading>
                        <flux:heading size="lg" class="mt-1 text-neutral-900 dark:text-neutral-100">280</flux:heading>
                    </div>
                    <svg class="h-5 w-5 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <flux:input placeholder="Search displays..." class="w-64" icon="magnifying-glass" />
                <select class="w-40 rounded-lg border border-neutral-200 bg-white px-3 py-2 text-sm dark:border-neutral-700 dark:bg-neutral-900 dark:text-white">
                    <option value="all">{{ __('All Status') }}</option>
                    <option value="online">{{ __('Online') }}</option>
                    <option value="offline">{{ __('Offline') }}</option>
                    <option value="powered_off">{{ __('Powered Off') }}</option>
                </select>
                <select class="w-32 rounded-lg border border-neutral-200 bg-white px-3 py-2 text-sm dark:border-neutral-700 dark:bg-neutral-900 dark:text-white">
                    <option value="all">{{ __('All Floors') }}</option>
                    <option value="1">{{ __('Floor 1') }}</option>
                    <option value="2">{{ __('Floor 2') }}</option>
                    <option value="3">{{ __('Floor 3') }}</option>
                    <option value="4">{{ __('Floor 4') }}</option>
                </select>
            </div>
            <div class="flex items-center gap-2">
                <flux:button variant="subtle" icon="view-columns">{{ __('Grid') }}</flux:button>
                <flux:button variant="filled" icon="bars-3">{{ __('List') }}</flux:button>
            </div>
        </div>

        <!-- Displays Table -->
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-neutral-200 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                {{ __('Display') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                {{ __('Status') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                {{ __('Template') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                {{ __('Network') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                {{ __('Last Seen') }}
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                        <!-- Display Row 1 -->
                        <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/20">
                                        <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <flux:text class="text-sm font-medium">{{ __('Room 301') }}</flux:text>
                                        <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('Samsung 55" Smart TV') }}</flux:text>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <div class="h-2 w-2 rounded-full bg-green-500"></div>
                                    <flux:text class="text-sm text-green-600 dark:text-green-400">{{ __('Online') }}</flux:text>
                                </div>
                                <div class="flex items-center space-x-2 mt-1">
                                    <div class="h-2 w-2 rounded-full bg-green-500"></div>
                                    <flux:text class="text-xs text-green-600 dark:text-green-400">{{ __('Powered On') }}</flux:text>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <flux:text class="text-sm">{{ __('Welcome Template') }}</flux:text>
                                <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('Updated 2h ago') }}</flux:text>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <flux:text class="text-sm">{{ __('192.168.1.101') }}</flux:text>
                                <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('AA:BB:CC:DD:EE:01') }}</flux:text>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <flux:text class="text-sm">{{ __('2 minutes ago') }}</flux:text>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <flux:modal.trigger name="display-settings-301">
                                    <flux:button variant="subtle" size="sm" icon="cog-6-tooth">
                                        {{ __('Settings') }}
                                    </flux:button>
                                </flux:modal.trigger>
                            </td>
                        </tr>

                        <!-- Display Row 2 -->
                        <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/20">
                                        <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <flux:text class="text-sm font-medium">{{ __('Room 205') }}</flux:text>
                                        <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('LG 43" Smart TV') }}</flux:text>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <div class="h-2 w-2 rounded-full bg-red-500"></div>
                                    <flux:text class="text-sm text-red-600 dark:text-red-400">{{ __('Offline') }}</flux:text>
                                </div>
                                <div class="flex items-center space-x-2 mt-1">
                                    <div class="h-2 w-2 rounded-full bg-neutral-400"></div>
                                    <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('Unknown') }}</flux:text>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('No template') }}</flux:text>
                                <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('Device offline') }}</flux:text>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <flux:text class="text-sm">{{ __('192.168.1.105') }}</flux:text>
                                <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('AA:BB:CC:DD:EE:05') }}</flux:text>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <flux:text class="text-sm text-red-600 dark:text-red-400">{{ __('1 hour ago') }}</flux:text>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <flux:modal.trigger name="display-settings-205">
                                    <flux:button variant="subtle" size="sm" icon="cog-6-tooth" disabled>
                                        {{ __('Settings') }}
                                    </flux:button>
                                </flux:modal.trigger>
                            </td>
                        </tr>

                        <!-- Display Row 3 -->
                        <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/20">
                                        <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <flux:text class="text-sm font-medium">{{ __('Lobby Main') }}</flux:text>
                                        <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('Sony 65" Professional') }}</flux:text>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <div class="h-2 w-2 rounded-full bg-green-500"></div>
                                    <flux:text class="text-sm text-green-600 dark:text-green-400">{{ __('Online') }}</flux:text>
                                </div>
                                <div class="flex items-center space-x-2 mt-1">
                                    <div class="h-2 w-2 rounded-full bg-yellow-500"></div>
                                    <flux:text class="text-xs text-yellow-600 dark:text-yellow-400">{{ __('Standby') }}</flux:text>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <flux:text class="text-sm">{{ __('Hotel Info Template') }}</flux:text>
                                <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('Updated 5m ago') }}</flux:text>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <flux:text class="text-sm">{{ __('192.168.1.200') }}</flux:text>
                                <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('AA:BB:CC:DD:EE:FF') }}</flux:text>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <flux:text class="text-sm">{{ __('Just now') }}</flux:text>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <flux:modal.trigger name="display-settings-lobby">
                                    <flux:button variant="subtle" size="sm" icon="cog-6-tooth">
                                        {{ __('Settings') }}
                                    </flux:button>
                                </flux:modal.trigger>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between">
            <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">
                {{ __('Showing 1 to 3 of 280 displays') }}
            </flux:text>
            <div class="flex items-center space-x-2">
                <flux:button variant="subtle" size="sm" icon="chevron-left" disabled>{{ __('Previous') }}</flux:button>
                <flux:button variant="filled" size="sm">1</flux:button>
                <flux:button variant="subtle" size="sm">2</flux:button>
                <flux:button variant="subtle" size="sm">3</flux:button>
                <flux:button variant="subtle" size="sm">...</flux:button>
                <flux:button variant="subtle" size="sm">94</flux:button>
                <flux:button variant="subtle" size="sm" icon="chevron-right">{{ __('Next') }}</flux:button>
            </div>
        </div>
    </div>

    <!-- Display Settings Modal for Room 301 -->
    <flux:modal name="display-settings-301" class="max-w-2xl">
        <div class="p-6">
            <div class="mb-6">
                <flux:heading size="lg">{{ __('Display Settings - Room 301') }}</flux:heading>
                <flux:subheading>{{ __('Samsung 55" Smart TV') }}</flux:subheading>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <!-- Power Controls -->
                <div class="space-y-4">
                    <flux:heading size="base">{{ __('Power Controls') }}</flux:heading>
                    
                    <div class="flex items-center justify-between p-3 rounded-lg border border-neutral-200 dark:border-neutral-700">
                        <div>
                            <flux:text class="text-sm font-medium">{{ __('Display Power') }}</flux:text>
                            <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('Turn display on/off') }}</flux:text>
                        </div>
                        <flux:button variant="primary" size="sm">{{ __('Power Off') }}</flux:button>
                    </div>

                    <div class="flex items-center justify-between p-3 rounded-lg border border-neutral-200 dark:border-neutral-700">
                        <div>
                            <flux:text class="text-sm font-medium">{{ __('Restart Display') }}</flux:text>
                            <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('Reboot the device') }}</flux:text>
                        </div>
                        <flux:button variant="filled" size="sm">{{ __('Restart') }}</flux:button>
                    </div>
                </div>

                <!-- Volume & Audio -->
                <div class="space-y-4">
                    <flux:heading size="base">{{ __('Audio Settings') }}</flux:heading>
                    
                    <div class="p-3 rounded-lg border border-neutral-200 dark:border-neutral-700">
                        <flux:text class="text-sm font-medium mb-2">{{ __('Volume Level') }}</flux:text>
                        <div class="flex items-center space-x-3">
                            <flux:button variant="subtle" size="sm" icon="speaker-x-mark"></flux:button>
                            <div class="flex-1">
                                <input type="range" min="0" max="100" value="75" class="w-full h-2 bg-neutral-200 rounded-lg appearance-none cursor-pointer dark:bg-neutral-700">
                            </div>
                            <flux:button variant="subtle" size="sm" icon="speaker-wave"></flux:button>
                            <flux:text class="text-sm font-medium w-8">75%</flux:text>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-3 rounded-lg border border-neutral-200 dark:border-neutral-700">
                        <div>
                            <flux:text class="text-sm font-medium">{{ __('Mute Audio') }}</flux:text>
                            <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('Temporarily disable sound') }}</flux:text>
                        </div>
                        <flux:button variant="filled" size="sm">{{ __('Mute') }}</flux:button>
                    </div>
                </div>

                <!-- Template Assignment -->
                <div class="space-y-4">
                    <flux:heading size="base">{{ __('Content Management') }}</flux:heading>
                    
                    <div class="p-3 rounded-lg border border-neutral-200 dark:border-neutral-700">
                        <flux:text class="text-sm font-medium mb-2">{{ __('Assigned Template') }}</flux:text>
                        <select class="w-full rounded-lg border border-neutral-200 bg-white px-3 py-2 text-sm dark:border-neutral-700 dark:bg-neutral-900 dark:text-white">
                            <option value="welcome" selected>{{ __('Welcome Template') }}</option>
                            <option value="info">{{ __('Hotel Info Template') }}</option>
                            <option value="events">{{ __('Events Template') }}</option>
                            <option value="weather">{{ __('Weather Template') }}</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-between p-3 rounded-lg border border-neutral-200 dark:border-neutral-700">
                        <div>
                            <flux:text class="text-sm font-medium">{{ __('Force Update') }}</flux:text>
                            <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('Push content immediately') }}</flux:text>
                        </div>
                        <flux:button variant="filled" size="sm">{{ __('Update') }}</flux:button>
                    </div>
                </div>

                <!-- Network Information -->
                <div class="space-y-4">
                    <flux:heading size="base">{{ __('Network Information') }}</flux:heading>
                    
                    <div class="p-3 rounded-lg border border-neutral-200 dark:border-neutral-700 space-y-2">
                        <div class="flex justify-between">
                            <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('IP Address') }}</flux:text>
                            <flux:text class="text-sm">192.168.1.101</flux:text>
                        </div>
                        <div class="flex justify-between">
                            <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('MAC Address') }}</flux:text>
                            <flux:text class="text-sm">AA:BB:CC:DD:EE:01</flux:text>
                        </div>
                        <div class="flex justify-between">
                            <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Signal Strength') }}</flux:text>
                            <flux:text class="text-sm text-green-600 dark:text-green-400">{{ __('Excellent') }}</flux:text>
                        </div>
                        <div class="flex justify-between">
                            <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Uptime') }}</flux:text>
                            <flux:text class="text-sm">3d 14h 22m</flux:text>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                <flux:modal.close>
                    <flux:button variant="subtle">{{ __('Cancel') }}</flux:button>
                </flux:modal.close>
                <flux:button variant="primary">{{ __('Save Changes') }}</flux:button>
            </div>
        </div>
    </flux:modal>

    <!-- Additional modals for other displays can be added similarly -->
    <flux:modal name="display-settings-lobby" class="max-w-2xl">
        <div class="p-6">
            <div class="mb-6">
                <flux:heading size="lg">{{ __('Display Settings - Lobby Main') }}</flux:heading>
                <flux:subheading>{{ __('Sony 65" Professional') }}</flux:subheading>
            </div>
            <!-- Similar content structure as above -->
            <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                <flux:modal.close>
                    <flux:button variant="subtle">{{ __('Cancel') }}</flux:button>
                </flux:modal.close>
                <flux:button variant="primary">{{ __('Save Changes') }}</flux:button>
            </div>
        </div>
    </flux:modal>
</x-layouts.app>
