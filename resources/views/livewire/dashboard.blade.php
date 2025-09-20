<?php

use App\Models\IptvChannel;
use App\Models\Display;
use function Livewire\Volt\{with, layout, title};

layout('components.layouts.app');
title(__('Dashboard'));

// Provide data to view
with(fn () => [
    'totalChannels' => IptvChannel::count(),
    'activeChannels' => IptvChannel::where('status', 'active')->count(),
    'inactiveChannels' => IptvChannel::where('status', 'inactive')->count(),
    'totalDisplays' => Display::count(),
    'activeDisplays' => Display::where('online', true)->count(),
    'inactiveDisplays' => Display::where('online', false)->count(),
    'recentDisplays' => Display::orderBy('last_seen_at', 'desc')->limit(3)->get(),
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
                    <flux:heading size="2xl" class="mt-2 text-green-600 dark:text-green-400">{{ $activeDisplays }}</flux:heading>
                    <flux:text class="mt-1 text-sm text-neutral-600 dark:text-neutral-300">
                        {{ __('out of :total total', ['total' => $totalDisplays]) }}
                    </flux:text>
                </div>
                <div class="flex h-12 w-12 items-center justify-center">
                    <img src="https://cdn.devdojo.com/tails/images/IbGQYwLTcfsjEyIQNsMWcktv7APAtED5V7uprns6.png" class="w-16 h-16 object-cover object-center rounded-lg">
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                @if($totalDisplays > 0)
                    <span class="text-green-600 dark:text-green-400">{{ number_format(($activeDisplays / $totalDisplays) * 100, 1) }}%</span>
                    <span class="ml-1 text-neutral-500 dark:text-neutral-400">{{ __('online') }}</span>
                @else
                    <span class="text-neutral-500 dark:text-neutral-400">{{ __('No displays configured') }}</span>
                @endif
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
                <div class="flex h-12 w-12 items-center justify-center rounded-lg">
                    <img src="https://cdn.devdojo.com/tails/images/1rPLOdFzW3em2hwPvF3zTvX5hqOWfAJjy8eapci4.png" class="w-18 h-18 object-cover object-center rounded-lg">
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
                <div class="flex h-12 w-12 items-center justify-center rounded-lg">
                    <img src="https://cdn.devdojo.com/tails/images/EP701wZxQLDyGiN41iUJhgMpLcEAx3RVnvCJX17L.png" class="w-18 h-18 object-cover object-center rounded-lg">
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
                    @forelse($recentDisplays as $display)
                        <!-- Activity Item -->
                        <div class="flex items-start space-x-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full {{ $display->online ? 'bg-green-100 dark:bg-green-900/20' : 'bg-red-100 dark:bg-red-900/20' }}">
                                @if($display->online)
                                    <svg class="h-4 w-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @else
                                    <svg class="h-4 w-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <flux:text class="text-sm font-medium">
                                    {{ $display->name }} {{ $display->online ? __('is online') : __('is offline') }}
                                    @if($display->connection_code)
                                        <span class="text-xs text-neutral-500">({{ $display->connection_code }})</span>
                                    @endif
                                </flux:text>
                                <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">
                                    @if($display->last_seen_at)
                                        {{ $display->last_seen_at->diffForHumans() }}
                                    @else
                                        {{ __('Never connected') }}
                                    @endif
                                </flux:text>
                            </div>
                        </div>
                    @empty
                        <!-- No displays activity -->
                        <div class="flex items-start space-x-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-neutral-100 dark:bg-neutral-800">
                                <svg class="h-4 w-4 text-neutral-600 dark:text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <flux:text class="text-sm font-medium">{{ __('No displays configured') }}</flux:text>
                                <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('Add your first display to get started') }}</flux:text>
                            </div>
                        </div>
                    @endforelse
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