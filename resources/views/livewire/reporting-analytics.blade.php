<?php

use function Livewire\Volt\{with, layout, title};

layout('components.layouts.app');
title(__('Reporting & Analytics'));

// Provide data to view
with(fn () => [
    'totalDisplays' => 280,
    'uptime' => 99.2,
    'activeUsers' => 24,
    'dataUsage' => '2.4TB',
    'onlineDisplays' => 247,
    'offlineDisplays' => 12,
    'standbyDisplays' => 21,
    'templateData' => [
        ['name' => 'Welcome Template', 'count' => 156, 'percentage' => 55.7, 'color' => '#3B82F6'],
        ['name' => 'Hotel Info', 'count' => 89, 'percentage' => 31.8, 'color' => '#10B981'],
        ['name' => 'Entertainment', 'count' => 35, 'percentage' => 12.5, 'color' => '#8B5CF6'],
    ],
    'systemHealth' => [
        'cpu' => 23,
        'memory' => 67,
        'storage' => 45,
        'network' => 78,
    ],
    'recentActivity' => [
        ['type' => 'success', 'message' => 'Template updated: Welcome Screen', 'time' => '2 minutes ago by John Doe'],
        ['type' => 'info', 'message' => 'Display added: Room 402', 'time' => '15 minutes ago by Admin'],
        ['type' => 'warning', 'message' => 'Display offline: Room 205', 'time' => '1 hour ago - System Alert'],
        ['type' => 'purple', 'message' => 'User login: Jane Smith', 'time' => '3 hours ago from 192.168.1.45'],
    ],
    'recentReports' => [
        ['name' => 'March 2024 Performance Report', 'type' => 'Performance', 'time' => '2 hours ago', 'size' => '2.4 MB'],
        ['name' => 'Weekly Usage Analytics', 'type' => 'Usage', 'time' => '1 day ago', 'size' => '1.8 MB'],
        ['name' => 'System Maintenance Report', 'type' => 'Maintenance', 'time' => '3 days ago', 'size' => '956 KB'],
    ],
]);

?>

<div>
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl" level="1">{{ __('Reporting & Analytics') }}</flux:heading>
                <flux:subheading class="mt-1">{{ __('Monitor performance and generate detailed reports') }}</flux:subheading>
            </div>
            <div class="flex items-center gap-3">
                <flux:button variant="filled" icon="document-arrow-down">
                    {{ __('Export Data') }}
                </flux:button>
                <flux:button variant="primary" icon="document-plus">
                    {{ __('Generate Report') }}
                </flux:button>
            </div>
        </div>

        <!-- Quick Stats Overview -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-4">
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:subheading class="text-neutral-500 dark:text-neutral-400">{{ __('Total Displays') }}</flux:subheading>
                        <flux:heading size="2xl" class="mt-2 text-neutral-900 dark:text-neutral-100">{{ $totalDisplays }}</flux:heading>
                        <flux:text class="mt-1 text-sm text-green-600 dark:text-green-400">
                            {{ __('↗ +5.2% from last month') }}
                        </flux:text>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/20">
                        <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:subheading class="text-neutral-500 dark:text-neutral-400">{{ __('Uptime') }}</flux:subheading>
                        <flux:heading size="2xl" class="mt-2 text-green-600 dark:text-green-400">{{ $uptime }}%</flux:heading>
                        <flux:text class="mt-1 text-sm text-green-600 dark:text-green-400">
                            {{ __('↗ +0.3% from last week') }}
                        </flux:text>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900/20">
                        <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:subheading class="text-neutral-500 dark:text-neutral-400">{{ __('Active Users') }}</flux:subheading>
                        <flux:heading size="2xl" class="mt-2 text-purple-600 dark:text-purple-400">{{ $activeUsers }}</flux:heading>
                        <flux:text class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                            {{ __('→ No change') }}
                        </flux:text>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-900/20">
                        <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:subheading class="text-neutral-500 dark:text-neutral-400">{{ __('Data Usage') }}</flux:subheading>
                        <flux:heading size="2xl" class="mt-2 text-orange-600 dark:text-orange-400">{{ $dataUsage }}</flux:heading>
                        <flux:text class="mt-1 text-sm text-orange-600 dark:text-orange-400">
                            {{ __('↗ +12% from last month') }}
                        </flux:text>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-orange-100 dark:bg-orange-900/20">
                        <svg class="h-6 w-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter and Time Range -->
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <flux:text class="text-sm font-medium">{{ __('Time Range:') }}</flux:text>
                <select class="rounded-lg border border-neutral-200 bg-white px-3 py-2 text-sm dark:border-neutral-700 dark:bg-neutral-900 dark:text-white">
                    <option value="24h">{{ __('Last 24 Hours') }}</option>
                    <option value="7d" selected>{{ __('Last 7 Days') }}</option>
                    <option value="30d">{{ __('Last 30 Days') }}</option>
                    <option value="90d">{{ __('Last 90 Days') }}</option>
                    <option value="custom">{{ __('Custom Range') }}</option>
                </select>
                <flux:button variant="subtle" icon="arrow-path" size="sm">
                    {{ __('Refresh') }}
                </flux:button>
            </div>
            <div class="flex items-center gap-2">
                <flux:button variant="subtle" size="sm" icon="chart-bar">{{ __('Charts') }}</flux:button>
                <flux:button variant="filled" size="sm" icon="table-cells">{{ __('Tables') }}</flux:button>
            </div>
        </div>

        <!-- Main Analytics Grid -->
        <div class="grid gap-6 lg:grid-cols-2">
            <!-- Display Performance Chart -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="mb-4 flex items-center justify-between">
                    <flux:heading size="lg">{{ __('Display Performance') }}</flux:heading>
                    <flux:button variant="subtle" size="sm" icon="ellipsis-horizontal">
                        {{ __('Options') }}
                    </flux:button>
                </div>
                <div class="relative h-64">
                    <canvas id="displayPerformanceChart" width="400" height="200"></canvas>
                </div>
                <div class="mt-4 grid grid-cols-3 gap-4">
                    <div class="text-center">
                        <flux:text class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $onlineDisplays }}</flux:text>
                        <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('Online') }}</flux:text>
                    </div>
                    <div class="text-center">
                        <flux:text class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $offlineDisplays }}</flux:text>
                        <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('Offline') }}</flux:text>
                    </div>
                    <div class="text-center">
                        <flux:text class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $standbyDisplays }}</flux:text>
                        <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('Standby') }}</flux:text>
                    </div>
                </div>
            </div>

            <!-- Template Usage Chart -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="mb-4 flex items-center justify-between">
                    <flux:heading size="lg">{{ __('Template Usage') }}</flux:heading>
                    <flux:button variant="subtle" size="sm" icon="ellipsis-horizontal">
                        {{ __('Options') }}
                    </flux:button>
                </div>
                <div class="relative h-64">
                    <canvas id="templateUsageChart" width="400" height="200"></canvas>
                </div>
                <div class="mt-4 space-y-2">
                    @foreach($templateData as $template)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <div class="h-3 w-3 rounded-full" style="background-color: {{ $template['color'] }}"></div>
                            <flux:text class="text-sm">{{ $template['name'] }}</flux:text>
                        </div>
                        <flux:text class="text-sm font-medium">{{ $template['count'] }} ({{ $template['percentage'] }}%)</flux:text>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- System Health -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="mb-4 flex items-center justify-between">
                    <flux:heading size="lg">{{ __('System Health') }}</flux:heading>
                    <flux:button variant="subtle" size="sm" icon="ellipsis-horizontal">
                        {{ __('Options') }}
                    </flux:button>
                </div>
                <div class="space-y-4">
                    <!-- CPU Usage -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <flux:text class="text-sm font-medium">{{ __('CPU Usage') }}</flux:text>
                            <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ $systemHealth['cpu'] }}%</flux:text>
                        </div>
                        <div class="w-full bg-neutral-200 rounded-full h-2 dark:bg-neutral-700">
                            <div class="bg-green-600 h-2 rounded-full" style="width: {{ $systemHealth['cpu'] }}%"></div>
                        </div>
                    </div>

                    <!-- Memory Usage -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <flux:text class="text-sm font-medium">{{ __('Memory Usage') }}</flux:text>
                            <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ $systemHealth['memory'] }}%</flux:text>
                        </div>
                        <div class="w-full bg-neutral-200 rounded-full h-2 dark:bg-neutral-700">
                            <div class="bg-yellow-600 h-2 rounded-full" style="width: {{ $systemHealth['memory'] }}%"></div>
                        </div>
                    </div>

                    <!-- Storage Usage -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <flux:text class="text-sm font-medium">{{ __('Storage Usage') }}</flux:text>
                            <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ $systemHealth['storage'] }}%</flux:text>
                        </div>
                        <div class="w-full bg-neutral-200 rounded-full h-2 dark:bg-neutral-700">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $systemHealth['storage'] }}%"></div>
                        </div>
                    </div>

                    <!-- Network Throughput -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <flux:text class="text-sm font-medium">{{ __('Network Throughput') }}</flux:text>
                            <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">234 Mbps</flux:text>
                        </div>
                        <div class="w-full bg-neutral-200 rounded-full h-2 dark:bg-neutral-700">
                            <div class="bg-purple-600 h-2 rounded-full" style="width: {{ $systemHealth['network'] }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Log -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="mb-4 flex items-center justify-between">
                    <flux:heading size="lg">{{ __('Activity Log') }}</flux:heading>
                    <flux:button variant="subtle" size="sm" :href="route('dashboard')" wire:navigate>
                        {{ __('View All') }}
                    </flux:button>
                </div>
                <div class="space-y-3">
                    @foreach($recentActivity as $activity)
                    <div class="flex items-start space-x-3">
                        <div class="flex h-6 w-6 items-center justify-center rounded-full 
                            @if($activity['type'] === 'success') bg-green-100 dark:bg-green-900/20
                            @elseif($activity['type'] === 'info') bg-blue-100 dark:bg-blue-900/20
                            @elseif($activity['type'] === 'warning') bg-yellow-100 dark:bg-yellow-900/20
                            @else bg-purple-100 dark:bg-purple-900/20
                            @endif">
                            <div class="h-2 w-2 rounded-full 
                                @if($activity['type'] === 'success') bg-green-600
                                @elseif($activity['type'] === 'info') bg-blue-600
                                @elseif($activity['type'] === 'warning') bg-yellow-600
                                @else bg-purple-600
                                @endif"></div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <flux:text class="text-sm">{{ $activity['message'] }}</flux:text>
                            <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ $activity['time'] }}</flux:text>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Report Generation Section -->
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <div class="mb-6">
                <flux:heading size="lg">{{ __('Generate Custom Reports') }}</flux:heading>
                <flux:subheading>{{ __('Create detailed reports and export them in various formats') }}</flux:subheading>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <!-- Report Types -->
                <div>
                    <flux:heading size="base" class="mb-3">{{ __('Report Type') }}</flux:heading>
                    <div class="space-y-3">
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="report_type" value="performance" class="rounded border-neutral-300 text-blue-600 focus:ring-blue-500" checked>
                            <flux:text class="text-sm">{{ __('Performance Report') }}</flux:text>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="report_type" value="usage" class="rounded border-neutral-300 text-blue-600 focus:ring-blue-500">
                            <flux:text class="text-sm">{{ __('Usage Analytics') }}</flux:text>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="report_type" value="maintenance" class="rounded border-neutral-300 text-blue-600 focus:ring-blue-500">
                            <flux:text class="text-sm">{{ __('Maintenance Report') }}</flux:text>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="report_type" value="security" class="rounded border-neutral-300 text-blue-600 focus:ring-blue-500">
                            <flux:text class="text-sm">{{ __('Security Audit') }}</flux:text>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="report_type" value="custom" class="rounded border-neutral-300 text-blue-600 focus:ring-blue-500">
                            <flux:text class="text-sm">{{ __('Custom Report') }}</flux:text>
                        </label>
                    </div>
                </div>

                <!-- Filters -->
                <div>
                    <flux:heading size="base" class="mb-3">{{ __('Filters & Options') }}</flux:heading>
                    <div class="space-y-3">
                        <div>
                            <flux:text class="text-sm font-medium mb-1">{{ __('Date Range') }}</flux:text>
                            <select class="w-full rounded-lg border border-neutral-200 bg-white px-3 py-2 text-sm dark:border-neutral-700 dark:bg-neutral-900 dark:text-white">
                                <option value="7d">{{ __('Last 7 Days') }}</option>
                                <option value="30d">{{ __('Last 30 Days') }}</option>
                                <option value="90d">{{ __('Last 90 Days') }}</option>
                                <option value="custom">{{ __('Custom Range') }}</option>
                            </select>
                        </div>
                        <div>
                            <flux:text class="text-sm font-medium mb-1">{{ __('Location Filter') }}</flux:text>
                            <select class="w-full rounded-lg border border-neutral-200 bg-white px-3 py-2 text-sm dark:border-neutral-700 dark:bg-neutral-900 dark:text-white">
                                <option value="all">{{ __('All Locations') }}</option>
                                <option value="floor1">{{ __('Floor 1') }}</option>
                                <option value="floor2">{{ __('Floor 2') }}</option>
                                <option value="floor3">{{ __('Floor 3') }}</option>
                                <option value="lobby">{{ __('Lobby Areas') }}</option>
                            </select>
                        </div>
                        <div>
                            <flux:text class="text-sm font-medium mb-1">{{ __('Include Data') }}</flux:text>
                            <div class="space-y-2">
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" class="rounded border-neutral-300 text-blue-600 focus:ring-blue-500" checked>
                                    <flux:text class="text-sm">{{ __('Performance Metrics') }}</flux:text>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" class="rounded border-neutral-300 text-blue-600 focus:ring-blue-500" checked>
                                    <flux:text class="text-sm">{{ __('Usage Statistics') }}</flux:text>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" class="rounded border-neutral-300 text-blue-600 focus:ring-blue-500">
                                    <flux:text class="text-sm">{{ __('Error Logs') }}</flux:text>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Export Options -->
                <div>
                    <flux:heading size="base" class="mb-3">{{ __('Export Options') }}</flux:heading>
                    <div class="space-y-3">
                        <div>
                            <flux:text class="text-sm font-medium mb-1">{{ __('Format') }}</flux:text>
                            <select class="w-full rounded-lg border border-neutral-200 bg-white px-3 py-2 text-sm dark:border-neutral-700 dark:bg-neutral-900 dark:text-white">
                                <option value="pdf">{{ __('PDF Document') }}</option>
                                <option value="excel">{{ __('Excel Spreadsheet') }}</option>
                                <option value="csv">{{ __('CSV File') }}</option>
                                <option value="json">{{ __('JSON Data') }}</option>
                            </select>
                        </div>
                        <div>
                            <flux:text class="text-sm font-medium mb-1">{{ __('Email Report') }}</flux:text>
                            <flux:input placeholder="Enter email address..." class="w-full" type="email" />
                        </div>
                        <div>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" class="rounded border-neutral-300 text-blue-600 focus:ring-blue-500">
                                <flux:text class="text-sm">{{ __('Schedule recurring reports') }}</flux:text>
                            </label>
                        </div>
                    </div>

                    <div class="mt-6 space-y-2">
                        <flux:button variant="primary" class="w-full" icon="document-arrow-down">
                            {{ __('Generate & Download') }}
                        </flux:button>
                        <flux:button variant="filled" class="w-full" icon="paper-airplane">
                            {{ __('Generate & Email') }}
                        </flux:button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Reports -->
        <div class="rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
            <div class="p-6">
                <div class="mb-4 flex items-center justify-between">
                    <flux:heading size="lg">{{ __('Recent Reports') }}</flux:heading>
                    <flux:button variant="subtle" size="sm">
                        {{ __('View All') }}
                    </flux:button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="border-b border-neutral-200 dark:border-neutral-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                    {{ __('Report Name') }}
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                    {{ __('Type') }}
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                    {{ __('Generated') }}
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                    {{ __('Size') }}
                                </th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                    {{ __('Actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                            @foreach($recentReports as $report)
                            <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <flux:text class="text-sm font-medium">{{ $report['name'] }}</flux:text>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="rounded-full 
                                        @if($report['type'] === 'Performance') bg-blue-100 px-2 py-1 text-xs text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                        @elseif($report['type'] === 'Usage') bg-green-100 px-2 py-1 text-xs text-green-800 dark:bg-green-900 dark:text-green-200
                                        @else bg-orange-100 px-2 py-1 text-xs text-orange-800 dark:bg-orange-900 dark:text-orange-200
                                        @endif">{{ $report['type'] }}</span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <flux:text class="text-sm">{{ $report['time'] }}</flux:text>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <flux:text class="text-sm">{{ $report['size'] }}</flux:text>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <flux:button variant="subtle" size="sm" icon="arrow-down-tray">
                                            {{ __('Download') }}
                                        </flux:button>
                                        <flux:button variant="subtle" size="sm" icon="share">
                                            {{ __('Share') }}
                                        </flux:button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Display Performance Chart (Doughnut)
        const displayCtx = document.getElementById('displayPerformanceChart').getContext('2d');
        new Chart(displayCtx, {
            type: 'doughnut',
            data: {
                labels: ['Online', 'Offline', 'Standby'],
                datasets: [{
                    data: [{{ $onlineDisplays }}, {{ $offlineDisplays }}, {{ $standbyDisplays }}],
                    backgroundColor: [
                        '#10B981',
                        '#EF4444',
                        '#F59E0B'
                    ],
                    borderWidth: 0,
                    cutout: '70%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Template Usage Chart (Pie)
        const templateCtx = document.getElementById('templateUsageChart').getContext('2d');
        new Chart(templateCtx, {
            type: 'pie',
            data: {
                labels: @json(collect($templateData)->pluck('name')),
                datasets: [{
                    data: @json(collect($templateData)->pluck('count')),
                    backgroundColor: @json(collect($templateData)->pluck('color')),
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
</div>
