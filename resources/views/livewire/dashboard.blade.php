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
                    <svg height="200px" width="200px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512.001 512.001" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#ABB8B9;" d="M490.666,58.668H21.333c-5.865,0-10.665,4.8-10.665,10.666v319.999c0,5.868,4.8,10.666,10.665,10.666 h88.755h291.826h88.751c5.868,0,10.666-4.798,10.666-10.666V69.334C501.333,63.468,496.534,58.668,490.666,58.668z"></path> <g> <path style="fill:#000003;" d="M490.666,48H21.333C9.57,48,0,57.571,0,69.334v319.999c0,11.763,9.57,21.334,21.333,21.334h72.042 l-17.719,38.175c-1.533,3.304-1.275,7.161,0.686,10.23c1.959,3.07,5.35,4.928,8.992,4.928h341.334c0.007,0,0.015,0,0.021,0 c5.892,0,10.667-4.776,10.667-10.667c0-1.844-0.468-3.581-1.292-5.095l-17.438-37.571h72.041c11.763,0,21.334-9.571,21.334-21.334 V69.334C512,57.571,502.429,48,490.666,48z M409.955,442.666H102.044l14.852-31.998h278.208L409.955,442.666z M401.916,389.332 c-0.001,0-0.002,0-0.002,0H110.087c-0.004,0-0.009,0.001-0.013,0.001h-88.74L21.333,69.335l469.332-0.001l0.004,319.998H401.916z"></path> <path style="fill:#000003;" d="M53.333,292.453c-5.892,0-10.667,4.776-10.667,10.668v54.214c0,5.892,4.776,10.667,10.667,10.667 s10.667-4.776,10.667-10.667v-54.214C64.001,297.229,59.226,292.453,53.333,292.453z"></path> <path style="fill:#000003;" d="M53.329,283.144c5.892,0,10.667-4.776,10.667-10.668v-0.254c0-5.892-4.776-10.668-10.667-10.668 c-5.891,0-10.667,4.776-10.667,10.668v0.254C42.661,278.368,47.438,283.144,53.329,283.144z"></path> <path style="fill:#000003;" d="M458.663,175.524c-5.891,0-10.668,4.776-10.668,10.667v0.256c0,5.892,4.777,10.667,10.668,10.667 c5.892,0,10.667-4.776,10.667-10.667v-0.256C469.33,180.3,464.554,175.524,458.663,175.524z"></path> <path style="fill:#000003;" d="M458.667,90.668c-5.892,0-10.667,4.776-10.667,10.667v54.212c0,5.892,4.776,10.667,10.667,10.667 s10.668-4.776,10.668-10.667v-54.212C469.334,95.444,464.558,90.668,458.667,90.668z"></path> </g> </g></svg>
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
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/20">
                   <svg viewBox="0 0 73 73" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>web-components/html-templates</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="web-components/html-templates" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="container" transform="translate(2.000000, 2.000000)" fill-rule="nonzero"> <rect id="mask" stroke="#375E87" stroke-width="2" fill="#FFFFFF" x="-1" y="-1" width="71" height="71" rx="14"> </rect> <g id="web-design" transform="translate(11.000000, 12.000000)"> <path d="M42.1161565,44.5459286 C42.1161565,45.8879864 41.0284422,46.9757007 39.6863844,46.9757007 L7.28931633,46.9757007 C5.9472585,46.9757007 4.85954422,45.8879864 4.85954422,44.5459286 L4.85954422,2.42977211 C4.85954422,1.08771429 5.9472585,0 7.28931633,0 L39.6863844,0 C41.0284422,0 42.1161565,1.08771429 42.1161565,2.42977211 L42.1161565,44.5459286 Z" id="Shape" fill="#87CED9"> </path> <path d="M39.6863844,46.9757806 L2.42977211,46.9757806 C1.08771429,46.9757806 0,45.8879864 0,44.5459286 L0,42.1161565 L37.2566122,42.1161565 L37.2566122,44.5459286 C37.2566122,45.8879864 38.3443265,46.9757806 39.6863844,46.9757806 Z" id="Shape" fill="#4398D1"> </path> <rect id="Rectangle-path" fill="#FDA72F" x="0" y="12.9588112" width="16.198534" height="9.71908844"> </rect> <path d="M4.28691156,19.456881 L2.66709014,17.8370595 C2.35119898,17.5211684 2.35119898,17.0076854 2.66709014,16.6917942 L4.28691156,15.0719728 L5.43217687,16.2172381 L4.38490816,17.2645068 L5.43217687,18.3116156 L4.28691156,19.456881 Z" id="Shape" fill="#FF8A3D"> </path> <path d="M11.9116224,19.456881 L10.7663571,18.3116156 L11.8136259,17.2643469 L10.7663571,16.2170782 L11.9116224,15.0718129 L13.5314439,16.6916344 C13.847335,17.0075255 13.847335,17.5210085 13.5314439,17.8368997 L11.9116224,19.456881 Z" id="Shape" fill="#FF8A3D"> </path> <rect id="Rectangle-path" fill="#FF8A3D" transform="translate(8.098304, 17.264943) rotate(-71.554180) translate(-8.098304, -17.264943) " x="5.53702631" y="16.4550523" width="5.12255456" height="1.61978168"> </rect> <rect id="Rectangle-path" fill="#4398D1" x="19.4382568" y="4.85954422" width="27.5375238" height="16.198534"> </rect> <polygon id="Shape" fill="#3269A1" points="46.9757806 17.8183554 41.3062857 14.5787126 35.0520085 17.8183554 27.5375238 12.9588112 19.4382568 17.8183554 19.4382568 21.0580782 46.9757806 21.0580782"> </polygon> <circle id="Oval" fill="#E34B87" cx="37.6616276" cy="10.1241037" r="2.02483673"> </circle> <rect id="Rectangle-path" fill="#E34B87" x="8.09926701" y="25.9176224" width="20.2481276" height="9.71908844"> </rect> <rect id="Rectangle-path" fill="#BF3D75" x="10.5290391" y="28.3473946" width="3.23972279" height="1.61982143"> </rect> <rect id="Rectangle-path" fill="#BF3D75" x="15.3885833" y="28.3473946" width="7.28931633" height="1.61982143"> </rect> <rect id="Rectangle-path" fill="#BF3D75" x="24.297801" y="28.3473946" width="1.61982143" height="1.61982143"> </rect> <rect id="Rectangle-path" fill="#BF3D75" x="10.5290391" y="31.5871173" width="9.71908844" height="1.61982143"> </rect> <rect id="Rectangle-path" fill="#BF3D75" x="21.8680289" y="31.5871173" width="4.04959354" height="1.61982143"> </rect> <rect id="Rectangle-path" fill="#5EB3D1" x="7.28931633" y="2.42977211" width="1.61982143" height="1.61982143"> </rect> <rect id="Rectangle-path" fill="#5EB3D1" x="10.5290391" y="2.42977211" width="1.61982143" height="1.61982143"> </rect> <rect id="Rectangle-path" fill="#5EB3D1" x="13.7687619" y="2.42977211" width="1.61982143" height="1.61982143"> </rect> <rect id="Rectangle-path" fill="#5EB3D1" x="7.28931633" y="5.6694949" width="9.71908844" height="1.61982143"> </rect> <rect id="Rectangle-path" fill="#E34B87" x="31.5871173" y="29.1573452" width="15.3885833" height="9.71908844"> </rect> <rect id="Rectangle-path" fill="#BF3D75" x="34.0168895" y="31.5871173" width="1.61982143" height="1.61982143"> </rect> <rect id="Rectangle-path" fill="#BF3D75" x="34.0168895" y="34.8268401" width="1.61982143" height="1.61982143"> </rect> <rect id="Rectangle-path" fill="#BF3D75" x="37.2566122" y="31.5871173" width="7.28931633" height="1.61982143"> </rect> <rect id="Rectangle-path" fill="#BF3D75" x="37.2566122" y="34.8268401" width="7.28931633" height="1.61982143"> </rect> <rect id="Rectangle-path" fill="#71C4D1" x="21.0580782" y="21.0580782" width="21.0580782" height="1.61982143"> </rect> <rect id="Rectangle-path" fill="#71C4D1" x="33.2070187" y="38.8765136" width="8.90921769" height="1.61982143"> </rect> <polygon id="Shape" fill="#71C4D1" points="16.198534 14.5787126 16.198534 22.6779796 4.85954422 22.6779796 4.85954422 24.297801 17.8183554 24.297801 17.8183554 14.5787126"> </polygon> <polygon id="Shape" fill="#71C4D1" points="28.3473946 27.5375238 28.3473946 35.6367908 9.71908844 35.6367908 9.71908844 37.2566122 29.9672959 37.2566122 29.9672959 27.5375238"> </polygon> </g> </g> </g> </g></svg>
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
                    <svg height="200px" width="200px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#7DD2F0;" d="M502.898,77.509c0-34.009-27.571-61.58-61.58-61.58H69.544c-34.009,0-61.58,27.571-61.58,61.58 v358.119c0,34.01,27.571,61.581,61.58,61.581h371.773c34.009,0,61.58-27.571,61.58-61.58V77.509z"></path> <g> <circle style="fill:#FFFFFF;" cx="96.659" cy="111.047" r="45.636"></circle> <path style="fill:#FFFFFF;" d="M192.488,65.409c-8.094,0-14.656,6.562-14.656,14.656v61.957c0,8.094,6.562,14.656,14.656,14.656 h255.535c8.094,0,14.657-6.562,14.657-14.656V80.064c0-8.094-6.562-14.656-14.657-14.656 C448.023,65.409,192.488,65.409,192.488,65.409z"></path> <circle style="fill:#FFFFFF;" cx="96.659" cy="255.772" r="45.636"></circle> <path style="fill:#FFFFFF;" d="M192.488,210.136c-8.094,0-14.656,6.562-14.656,14.656v61.957c0,8.094,6.562,14.656,14.656,14.656 h255.535c8.094,0,14.657-6.562,14.657-14.656v-61.957c0-8.094-6.562-14.656-14.657-14.656L192.488,210.136L192.488,210.136z"></path> <circle style="fill:#FFFFFF;" cx="96.659" cy="400.498" r="45.636"></circle> <path style="fill:#FFFFFF;" d="M448.023,446.133c8.094,0,14.657-6.562,14.657-14.657V369.52c0-8.094-6.562-14.656-14.657-14.656 H192.488c-8.094,0-14.656,6.562-14.656,14.656v61.957c0,8.094,6.562,14.657,14.656,14.657H448.023z"></path> </g> <path d="M441.887,505.173h-41.879c-4.714,0-8.533-3.821-8.533-8.533s3.819-8.533,8.533-8.533h41.879 c29.25,0,53.047-23.797,53.047-53.047V76.941c0-29.251-23.797-53.048-53.047-53.048H175.695c-4.714,0-8.533-3.821-8.533-8.533 s3.82-8.533,8.533-8.533h266.192C480.547,6.827,512,38.279,512,76.941V435.06C512,473.721,480.547,505.173,441.887,505.173z"></path> <path d="M365.874,505.173H70.113C31.453,505.173,0,473.721,0,435.06V76.941C0,38.279,31.453,6.827,70.113,6.827h71.448 c4.714,0,8.533,3.821,8.533,8.533s-3.82,8.533-8.533,8.533H70.113c-29.25,0-53.047,23.797-53.047,53.048V435.06 c0,29.25,23.797,53.047,53.047,53.047h295.761c4.714,0,8.533,3.821,8.533,8.533S370.588,505.173,365.874,505.173z"></path> <path d="M96.375,164.871c-29.868,0-54.167-24.3-54.167-54.167s24.3-54.167,54.167-54.167s54.167,24.3,54.167,54.167 S126.243,164.871,96.375,164.871z M96.375,73.602c-20.457,0-37.101,16.643-37.101,37.101s16.643,37.101,37.101,37.101 s37.101-16.643,37.101-37.101S116.834,73.602,96.375,73.602z"></path> <path d="M447.739,164.872H192.206c-12.786,0-23.19-10.403-23.19-23.19V79.725c0-12.786,10.404-23.189,23.19-23.189h174.611 c4.714,0,8.533,3.821,8.533,8.533s-3.82,8.533-8.533,8.533H192.206c-3.377,0-6.124,2.747-6.124,6.122v61.957 c0,3.377,2.747,6.124,6.124,6.124h255.535c3.377,0,6.124-2.747,6.124-6.124V79.725c0-3.376-2.747-6.122-6.124-6.122h-46.79 c-4.714,0-8.533-3.821-8.533-8.533c0-4.713,3.82-8.533,8.533-8.533h46.79c12.786,0,23.19,10.403,23.19,23.189v61.957 C470.93,154.469,460.527,164.872,447.739,164.872z"></path> <path d="M96.375,309.598c-29.868,0-54.167-24.3-54.167-54.167s24.3-54.167,54.167-54.167s54.167,24.3,54.167,54.167 S126.243,309.598,96.375,309.598z M96.375,218.33c-20.457,0-37.101,16.643-37.101,37.101s16.643,37.101,37.101,37.101 s37.101-16.643,37.101-37.101S116.834,218.33,96.375,218.33z"></path> <path d="M447.739,309.598H192.206c-12.786,0-23.19-10.403-23.19-23.189v-61.957c0-12.786,10.404-23.189,23.19-23.189h45.489 c4.714,0,8.533,3.821,8.533,8.533c0,4.713-3.82,8.533-8.533,8.533h-45.489c-3.377,0-6.124,2.747-6.124,6.122v61.957 c0,3.376,2.747,6.122,6.124,6.122h255.535c3.377,0,6.124-2.747,6.124-6.122v-61.957c0-3.376-2.747-6.122-6.124-6.122H271.829 c-4.714,0-8.533-3.821-8.533-8.533c0-4.713,3.82-8.533,8.533-8.533h175.911c12.786,0,23.19,10.403,23.19,23.189v61.957 C470.93,299.196,460.527,309.598,447.739,309.598z"></path> <path d="M96.375,454.327c-29.868,0-54.167-24.3-54.167-54.167c0-29.868,24.3-54.167,54.167-54.167s54.167,24.299,54.167,54.167 C150.543,430.028,126.243,454.327,96.375,454.327z M96.375,363.058c-20.457,0-37.101,16.643-37.101,37.101 c0,20.457,16.643,37.101,37.101,37.101s37.101-16.643,37.101-37.101C133.476,379.701,116.834,363.058,96.375,363.058z"></path> <path d="M447.739,454.327h-72.237c-4.714,0-8.533-3.821-8.533-8.533s3.82-8.533,8.533-8.533h72.237c3.377,0,6.124-2.747,6.124-6.124 V369.18c0-3.376-2.747-6.122-6.124-6.122H192.206c-3.377,0-6.124,2.747-6.124,6.122v61.957c0,3.377,2.747,6.124,6.124,6.124H341.37 c4.714,0,8.533,3.821,8.533,8.533s-3.82,8.533-8.533,8.533H192.206c-12.786,0-23.19-10.403-23.19-23.19V369.18 c0-12.786,10.404-23.189,23.19-23.189h255.535c12.786,0,23.19,10.403,23.19,23.189v61.957 C470.93,443.923,460.527,454.327,447.739,454.327z"></path> </g></svg>
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