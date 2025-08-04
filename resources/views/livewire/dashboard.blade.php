<?php

use App\Models\IptvChannel;
use function Livewire\Volt\{with, layout, title};

layout('components.layouts.app');
title(__('Dashboard'));

// Provide data to view
with(fn () => [
    'totalChannels' => IptvChannel::count(),
    'activeChannels' => IptvChannel::where('status', 'active')->count(),
    'inactiveChannels' => IptvChannel::where('status', 'inactive')->count(),
]);

?>

<div class="flex h-full w-full flex-1 flex-col gap-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">

        <div class="flex items-center gap-3">
            <flux:button variant="primary" icon="plus" :href="route('display-management')" wire:navigate>
                {{ __('Add Display') }}
            </flux:button>
        </div>
    </div>

    <!-- Key Statistics Row -->
    <div class="grid auto-rows-min gap-4 md:grid-cols-3">
        <!-- Active Displays Card -->
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-center justify-between">
                <div>
                    <flux:subheading class="text-neutral-500 dark:text-neutral-400">{{ __('Active Displays') }}</flux:subheading>
                    <flux:heading size="2xl" class="mt-2 text-green-600 dark:text-green-400">247</flux:heading>
                    <flux:text class="mt-1 text-sm text-neutral-600 dark:text-neutral-300">
                        {{ __('out of 280 total') }}
                    </flux:text>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900/20">
                    <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-green-600 dark:text-green-400">+12</span>
                <span class="ml-1 text-neutral-500 dark:text-neutral-400">{{ __('since yesterday') }}</span>
            </div>
        </div>

        <!-- Available Templates Card -->
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-center justify-between">
                <div>
                    <flux:subheading class="text-neutral-500 dark:text-neutral-400">{{ __('Templates') }}</flux:subheading>
                    <flux:heading size="2xl" class="mt-2 text-blue-600 dark:text-blue-400">42</flux:heading>
                    <flux:text class="mt-1 text-sm text-neutral-600 dark:text-neutral-300">
                        {{ __('active templates') }}
                    </flux:text>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/20">
                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-blue-600 dark:text-blue-400">+3</span>
                <span class="ml-1 text-neutral-500 dark:text-neutral-400">{{ __('new this week') }}</span>
            </div>
        </div>

        <!-- Active Channels Card -->
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-center justify-between">
                <div>
                    <flux:subheading class="text-neutral-500 dark:text-neutral-400">{{ __('Channels') }}</flux:subheading>
                    <flux:heading size="2xl" class="mt-2 text-purple-600 dark:text-purple-400">{{ $activeChannels }}</flux:heading>
                    <flux:text class="mt-1 text-sm text-neutral-600 dark:text-neutral-300">
                        {{ __('out of :total total', ['total' => $totalChannels]) }}
                    </flux:text>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-900/20">
                    <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2M7 4h10M7 4l-2 9a1 1 0 001 1h12a1 1 0 001-1L17 4M9 9v4m6-4v4"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                @if($totalChannels > 0)
                    <span class="text-purple-600 dark:text-purple-400">{{ number_format(($activeChannels / $totalChannels) * 100, 1) }}%</span>
                    <span class="ml-1 text-neutral-500 dark:text-neutral-400">{{ __('active channels') }}</span>
                @else
                    <span class="text-neutral-500 dark:text-neutral-400">{{ __('No channels configured') }}</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="grid auto-rows-min gap-4 md:grid-cols-2">
        <!-- Recent Activity -->
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
            <div class="p-6">
                <div class="mb-4 flex items-center justify-between">
                    <flux:heading size="lg">{{ __('Recent Activity') }}</flux:heading>
                    <flux:button variant="subtle" size="sm" :href="route('reporting-analytics')" wire:navigate>
                        {{ __('View All') }}
                    </flux:button>
                </div>
                
                <div class="space-y-4">
                    <!-- Activity Item -->
                    <div class="flex items-start space-x-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/20">
                            <svg class="h-4 w-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <flux:text class="text-sm font-medium">{{ __('Room 301 display activated') }}</flux:text>
                            <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('2 minutes ago') }}</flux:text>
                        </div>
                    </div>

                    <!-- Activity Item -->
                    <div class="flex items-start space-x-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/20">
                            <svg class="h-4 w-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <flux:text class="text-sm font-medium">{{ __('Welcome template updated') }}</flux:text>
                            <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('15 minutes ago') }}</flux:text>
                        </div>
                    </div>

                    <!-- Activity Item -->
                    <div class="flex items-start space-x-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-yellow-100 dark:bg-yellow-900/20">
                            <svg class="h-4 w-4 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <flux:text class="text-sm font-medium">{{ __('Display offline: Room 205') }}</flux:text>
                            <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('1 hour ago') }}</flux:text>
                        </div>
                    </div>

                    <!-- Activity Item -->
                    <div class="flex items-start space-x-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-purple-100 dark:bg-purple-900/20">
                            <svg class="h-4 w-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <flux:text class="text-sm font-medium">{{ __('New user registered: John Smith') }}</flux:text>
                            <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('3 hours ago') }}</flux:text>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions & System Status -->
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
            <div class="p-6">
                <flux:heading size="lg" class="mb-4">{{ __('Quick Actions') }}</flux:heading>
                
                <div class="space-y-3 mb-6">
                    <flux:button variant="filled" class="w-full justify-start" icon="computer-desktop" :href="route('display-management')" wire:navigate>
                        {{ __('Manage Displays') }}
                    </flux:button>
                    <flux:button variant="filled" class="w-full justify-start" icon="pencil-square" :href="route('template-management')" wire:navigate>
                        {{ __('Edit Templates') }}
                    </flux:button>
                    <flux:button variant="filled" class="w-full justify-start" icon="list-bullet" :href="route('channel-management')" wire:navigate>
                        {{ __('Configure Channels') }}
                    </flux:button>
                    <flux:button variant="filled" class="w-full justify-start" icon="clipboard-document-list" :href="route('reporting-analytics')" wire:navigate>
                        {{ __('View Analytics') }}
                    </flux:button>
                </div>

                <flux:heading size="base" class="mb-3">{{ __('System Status') }}</flux:heading>
                
                <div class="space-y-3">
                    <!-- System Status Item -->
                    <div class="flex items-center justify-between">
                        <flux:text class="text-sm">{{ __('Network Status') }}</flux:text>
                        <div class="flex items-center space-x-2">
                            <div class="h-2 w-2 rounded-full bg-green-500"></div>
                            <flux:text class="text-sm text-green-600 dark:text-green-400">{{ __('Online') }}</flux:text>
                        </div>
                    </div>

                    <!-- System Status Item -->
                    <div class="flex items-center justify-between">
                        <flux:text class="text-sm">{{ __('Server Health') }}</flux:text>
                        <div class="flex items-center space-x-2">
                            <div class="h-2 w-2 rounded-full bg-green-500"></div>
                            <flux:text class="text-sm text-green-600 dark:text-green-400">{{ __('Healthy') }}</flux:text>
                        </div>
                    </div>

                    <!-- System Status Item -->
                    <div class="flex items-center justify-between">
                        <flux:text class="text-sm">{{ __('Last Backup') }}</flux:text>
                        <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('2 hours ago') }}</flux:text>
                    </div>

                    <!-- System Status Item -->
                    <div class="flex items-center justify-between">
                        <flux:text class="text-sm">{{ __('Storage Used') }}</flux:text>
                        <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('2.4GB / 10GB') }}</flux:text>
                    </div>
                </div>
            </div>
        </div>
    </div>