<x-layouts.app :title="__('Template Management')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        
        <!-- Navigation -->
        <div class="flex items-center justify-between">

            <flux:navbar scrollable>
                <flux:navbar.item href="{{ route('template-management') }}" :current="request()->routeIs('template-management')">Overview</flux:navbar.item>
                <flux:navbar.item href="{{ route('template-ui') }}">UI</flux:navbar.item>
                <flux:navbar.item href="{{ route('templates') }}">Templates</flux:navbar.item>
            </flux:navbar>

            <div class="flex items-center gap-3">
                <flux:button variant="filled" icon="arrow-path" class="bg-blue-600 hover:bg-blue-700">
                    {{ __('Refresh Status') }}
                </flux:button>
                <flux:button variant="primary" icon="plus">
                    {{ __('Deploy Template') }}
                </flux:button>
            </div>
        </div>

        <!-- Template Statistics -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-4">
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:subheading class="text-neutral-500 dark:text-neutral-400">{{ __('Active Templates') }}</flux:subheading>
                        <flux:heading size="lg" class="mt-1 text-blue-600 dark:text-blue-400">8</flux:heading>
                    </div>
                    <div class="h-2 w-2 rounded-full bg-blue-500"></div>
                </div>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:subheading class="text-neutral-500 dark:text-neutral-400">{{ __('Deployed Displays') }}</flux:subheading>
                        <flux:heading size="lg" class="mt-1 text-green-600 dark:text-green-400">247</flux:heading>
                    </div>
                    <div class="h-2 w-2 rounded-full bg-green-500"></div>
                </div>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:subheading class="text-neutral-500 dark:text-neutral-400">{{ __('Updates Pending') }}</flux:subheading>
                        <flux:heading size="lg" class="mt-1 text-orange-600 dark:text-orange-400">12</flux:heading>
                    </div>
                    <div class="h-2 w-2 rounded-full bg-orange-500"></div>
                </div>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:subheading class="text-neutral-500 dark:text-neutral-400">{{ __('Failed Deployments') }}</flux:subheading>
                        <flux:heading size="lg" class="mt-1 text-red-600 dark:text-red-400">3</flux:heading>
                    </div>
                    <div class="h-2 w-2 rounded-full bg-red-500"></div>
                </div>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <flux:input placeholder="Search templates..." class="w-64" icon="magnifying-glass" />
                <select class="w-40 rounded-lg border border-neutral-200 bg-white px-3 py-2 text-sm dark:border-neutral-700 dark:bg-neutral-900 dark:text-white">
                    <option value="all">{{ __('All Templates') }}</option>
                    <option value="welcome">{{ __('Welcome') }}</option>
                    <option value="info">{{ __('Hotel Info') }}</option>
                    <option value="events">{{ __('Events') }}</option>
                    <option value="weather">{{ __('Weather') }}</option>
                </select>
                <select class="w-40 rounded-lg border border-neutral-200 bg-white px-3 py-2 text-sm dark:border-neutral-700 dark:bg-neutral-900 dark:text-white">
                    <option value="all">{{ __('All Status') }}</option>
                    <option value="active">{{ __('Active') }}</option>
                    <option value="updating">{{ __('Updating') }}</option>
                    <option value="failed">{{ __('Failed') }}</option>
                </select>
            </div>
        </div>

        <!-- Active Templates Table -->
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-center justify-between border-b border-neutral-200 p-6 dark:border-neutral-700">
                <div>
                    <flux:heading size="base">{{ __('Active Template Deployments') }}</flux:heading>
                    <flux:subheading>{{ __('Templates currently deployed to hotel displays') }}</flux:subheading>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-neutral-200 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                {{ __('Template') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                {{ __('Assigned Rooms') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                {{ __('Status') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                {{ __('Last Updated') }}
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                        @php
                            $templates = [
                                [
                                    'name' => 'Welcome Template',
                                    'description' => 'Standard guest welcome screen',
                                    'rooms' => ['101', '102', '103', '201', '202', '203', '301', '302'],
                                    'room_count' => 85,
                                    'status' => 'Active',
                                    'last_updated' => '2 hours ago',
                                    'color' => 'blue'
                                ],
                                [
                                    'name' => 'Hotel Information',
                                    'description' => 'Services, amenities, and contact info',
                                    'rooms' => ['Lobby', 'Reception', 'Restaurant'],
                                    'room_count' => 12,
                                    'status' => 'Active',
                                    'last_updated' => '1 day ago',
                                    'color' => 'green'
                                ],
                                [
                                    'name' => 'Event Schedule',
                                    'description' => 'Daily events and activities',
                                    'rooms' => ['Conference Room A', 'Conference Room B', 'Ballroom'],
                                    'room_count' => 8,
                                    'status' => 'Updating',
                                    'last_updated' => '15 minutes ago',
                                    'color' => 'orange'
                                ],
                                [
                                    'name' => 'Weather & News',
                                    'description' => 'Local weather and news updates',
                                    'rooms' => ['401', '402', '403', '404'],
                                    'room_count' => 45,
                                    'status' => 'Active',
                                    'last_updated' => '30 minutes ago',
                                    'color' => 'purple'
                                ],
                                [
                                    'name' => 'Spa & Wellness',
                                    'description' => 'Spa services and wellness programs',
                                    'rooms' => ['Spa Reception', 'Fitness Center'],
                                    'room_count' => 6,
                                    'status' => 'Failed',
                                    'last_updated' => '3 hours ago',
                                    'color' => 'red'
                                ],
                                [
                                    'name' => 'Restaurant Menu',
                                    'description' => 'Current menu and dining hours',
                                    'rooms' => ['Restaurant', 'Bar', 'Room Service'],
                                    'room_count' => 15,
                                    'status' => 'Active',
                                    'last_updated' => '4 hours ago',
                                    'color' => 'emerald'
                                ]
                            ];
                        @endphp
                        
                        @foreach($templates as $index => $template)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-{{ $template['color'] }}-100 dark:bg-{{ $template['color'] }}-900/20">
                                        <svg class="h-5 w-5 text-{{ $template['color'] }}-600 dark:text-{{ $template['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <flux:text class="text-sm font-medium">{{ $template['name'] }}</flux:text>
                                        <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ $template['description'] }}</flux:text>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-wrap gap-1 max-w-xs">
                                    @foreach(array_slice($template['rooms'], 0, 3) as $room)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-neutral-100 text-neutral-800 dark:bg-neutral-700 dark:text-neutral-200">
                                            {{ $room }}
                                        </span>
                                    @endforeach
                                    @if(count($template['rooms']) > 3)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-neutral-100 text-neutral-600 dark:bg-neutral-700 dark:text-neutral-400">
                                            +{{ count($template['rooms']) - 3 }} more
                                        </span>
                                    @endif
                                </div>
                                <flux:text class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">{{ $template['room_count'] }} displays total</flux:text>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($template['status'] === 'Active')
                                    <div class="flex items-center space-x-2">
                                        <div class="h-2 w-2 rounded-full bg-green-500"></div>
                                        <flux:text class="text-sm text-green-600 dark:text-green-400">{{ __('Active') }}</flux:text>
                                    </div>
                                @elseif($template['status'] === 'Updating')
                                    <div class="flex items-center space-x-2">
                                        <div class="h-2 w-2 rounded-full bg-orange-500 animate-pulse"></div>
                                        <flux:text class="text-sm text-orange-600 dark:text-orange-400">{{ __('Updating') }}</flux:text>
                                    </div>
                                @else
                                    <div class="flex items-center space-x-2">
                                        <div class="h-2 w-2 rounded-full bg-red-500"></div>
                                        <flux:text class="text-sm text-red-600 dark:text-red-400">{{ __('Failed') }}</flux:text>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <flux:text class="text-sm">{{ $template['last_updated'] }}</flux:text>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <flux:button variant="subtle" size="sm" icon="eye">
                                        {{ __('Preview') }}
                                    </flux:button>
                                    <flux:button variant="subtle" size="sm" icon="cog-6-tooth">
                                        {{ __('Manage') }}
                                    </flux:button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid gap-6 lg:grid-cols-2">
            <!-- Recent Template Updates -->
            <div class="rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
                <div class="border-b border-neutral-200 p-6 dark:border-neutral-700">
                    <flux:heading size="base">{{ __('Recent Activity') }}</flux:heading>
                    <flux:subheading>{{ __('Latest template deployment activity') }}</flux:subheading>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @php
                            $activities = [
                                ['action' => 'Template updated', 'template' => 'Welcome Template', 'rooms' => '85 rooms', 'time' => '2 hours ago', 'status' => 'success'],
                                ['action' => 'Deployment failed', 'template' => 'Spa & Wellness', 'rooms' => '6 rooms', 'time' => '3 hours ago', 'status' => 'error'],
                                ['action' => 'Template deployed', 'template' => 'Weather & News', 'rooms' => '45 rooms', 'time' => '1 day ago', 'status' => 'success'],
                                ['action' => 'Template removed', 'template' => 'Holiday Special', 'rooms' => '12 rooms', 'time' => '2 days ago', 'status' => 'neutral']
                            ];
                        @endphp
                        
                        @foreach($activities as $activity)
                        <div class="flex items-center space-x-3">
                            @if($activity['status'] === 'success')
                                <div class="flex-shrink-0 h-2 w-2 rounded-full bg-green-500"></div>
                            @elseif($activity['status'] === 'error')
                                <div class="flex-shrink-0 h-2 w-2 rounded-full bg-red-500"></div>
                            @else
                                <div class="flex-shrink-0 h-2 w-2 rounded-full bg-neutral-400"></div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <flux:text class="text-sm font-medium">{{ $activity['action'] }}</flux:text>
                                <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ $activity['template'] }} • {{ $activity['rooms'] }}</flux:text>
                            </div>
                            <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ $activity['time'] }}</flux:text>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Template Performance -->
            <div class="rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
                <div class="border-b border-neutral-200 p-6 dark:border-neutral-700">
                    <flux:heading size="base">{{ __('Template Performance') }}</flux:heading>
                    <flux:subheading>{{ __('Most popular and effective templates') }}</flux:subheading>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @php
                            $performance = [
                                ['name' => 'Welcome Template', 'usage' => '85', 'percentage' => '34%', 'trend' => 'up'],
                                ['name' => 'Weather & News', 'usage' => '45', 'percentage' => '18%', 'trend' => 'up'],
                                ['name' => 'Restaurant Menu', 'usage' => '15', 'percentage' => '6%', 'trend' => 'stable'],
                                ['name' => 'Hotel Information', 'usage' => '12', 'percentage' => '5%', 'trend' => 'down']
                            ];
                        @endphp
                        
                        @foreach($performance as $item)
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <flux:text class="text-sm font-medium">{{ $item['name'] }}</flux:text>
                                <div class="flex items-center mt-1">
                                    <div class="flex-1 bg-neutral-200 rounded-full h-2 dark:bg-neutral-700">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $item['percentage'] }}"></div>
                                    </div>
                                    <flux:text class="text-xs text-neutral-500 dark:text-neutral-400 ml-2">{{ $item['usage'] }}</flux:text>
                                </div>
                            </div>
                            <div class="ml-4 text-right">
                                <flux:text class="text-sm font-medium">{{ $item['percentage'] }}</flux:text>
                                @if($item['trend'] === 'up')
                                    <svg class="w-4 h-4 text-green-500 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17l9.2-9.2M17 17V7h-10"/>
                                    </svg>
                                @elseif($item['trend'] === 'down')
                                    <svg class="w-4 h-4 text-red-500 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 7l-9.2 9.2M7 7v10h10"/>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-neutral-400 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h8"/>
                                    </svg>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
