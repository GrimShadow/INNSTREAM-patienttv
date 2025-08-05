<?php

use function Livewire\Volt\{with, layout, title};

layout('components.layouts.app');
title(__('License'));

// Form properties
$licenseKey = '';
$isActivating = false;

// Activate license function
$activateLicense = function() use ($licenseKey) {
    $this->isActivating = true;
    
    // Simulate license activation
    sleep(2);
    
    // Reset form
    $this->licenseKey = '';
    $this->isActivating = false;
    
    // Close modal
    $this->dispatch('modal-close');
};

?>

<div>
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="2xl">{{ __('License Management') }}</flux:heading>
                <flux:subheading>{{ __('Manage your INNSTREAM IPTV license and features') }}</flux:subheading>
            </div>
            <flux:modal.trigger name="activate-license-modal">
                <flux:button variant="primary">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    {{ __('Activate License') }}
                </flux:button>
            </flux:modal.trigger>
        </div>

        <!-- License Status -->
        <div class="rounded-lg border border-green-200 bg-green-50 p-6 dark:border-green-800 dark:bg-green-900/20">
            <div class="flex items-center">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900/20">
                    <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <flux:text class="text-lg font-semibold text-green-800 dark:text-green-200">{{ __('License Active') }}</flux:text>
                    <flux:text class="text-sm text-green-600 dark:text-green-400">{{ __('Your INNSTREAM IPTV license is active and valid until December 31, 2025') }}</flux:text>
                </div>
            </div>
        </div>

        <!-- License Details -->
        <div class="grid gap-6 md:grid-cols-2">
            <!-- License Information -->
            <div class="rounded-lg border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <flux:heading size="lg" class="mb-4">{{ __('License Information') }}</flux:heading>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-neutral-100 dark:border-neutral-800">
                        <flux:text class="text-sm font-medium text-neutral-600 dark:text-neutral-400">{{ __('License Type') }}</flux:text>
                        <flux:text class="text-sm font-semibold">{{ __('Demo - View Only') }}</flux:text>
                    </div>
                    
                    <div class="flex justify-between items-center py-2 border-b border-neutral-100 dark:border-neutral-800">
                        <flux:text class="text-sm font-medium text-neutral-600 dark:text-neutral-400">{{ __('License Key') }}</flux:text>
                        <flux:text class="text-sm font-mono text-neutral-500 dark:text-neutral-400">{{ __('XXXX-XXXX-XXXX-XXXX') }}</flux:text>
                    </div>
                    
                    <div class="flex justify-between items-center py-2 border-b border-neutral-100 dark:border-neutral-800">
                        <flux:text class="text-sm font-medium text-neutral-600 dark:text-neutral-400">{{ __('Activation Date') }}</flux:text>
                        <flux:text class="text-sm">{{ __('August 2, 2025') }}</flux:text>
                    </div>
                    
                    <div class="flex justify-between items-center py-2 border-b border-neutral-100 dark:border-neutral-800">
                        <flux:text class="text-sm font-medium text-neutral-600 dark:text-neutral-400">{{ __('Expiration Date') }}</flux:text>
                        <flux:text class="text-sm">{{ __('December 31, 2025') }}</flux:text>
                    </div>
                    
                    <div class="flex justify-between items-center py-2">
                        <flux:text class="text-sm font-medium text-neutral-600 dark:text-neutral-400">{{ __('Days Remaining') }}</flux:text>
                        <flux:text class="text-sm font-semibold text-green-600 dark:text-green-400">{{ __('N/A') }}</flux:text>
                    </div>
                </div>
            </div>

            <!-- Usage Statistics -->
            <div class="rounded-lg border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <flux:heading size="lg" class="mb-4">{{ __('Usage Statistics') }}</flux:heading>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-neutral-100 dark:border-neutral-800">
                        <flux:text class="text-sm font-medium text-neutral-600 dark:text-neutral-400">{{ __('Active Users') }}</flux:text>
                        <flux:text class="text-sm font-semibold">{{ __('12 / 50') }}</flux:text>
                    </div>
                    
                    <div class="flex justify-between items-center py-2 border-b border-neutral-100 dark:border-neutral-800">
                        <flux:text class="text-sm font-medium text-neutral-600 dark:text-neutral-400">{{ __('Connected Displays') }}</flux:text>
                        <flux:text class="text-sm font-semibold">{{ __('8 / 25') }}</flux:text>
                    </div>
                    
                    <div class="flex justify-between items-center py-2 border-b border-neutral-100 dark:border-neutral-800">
                        <flux:text class="text-sm font-medium text-neutral-600 dark:text-neutral-400">{{ __('Channels') }}</flux:text>
                        <flux:text class="text-sm font-semibold">{{ __('45 / 100') }}</flux:text>
                    </div>
                    
                    <div class="flex justify-between items-center py-2 border-b border-neutral-100 dark:border-neutral-800">
                        <flux:text class="text-sm font-medium text-neutral-600 dark:text-neutral-400">{{ __('Templates') }}</flux:text>
                        <flux:text class="text-sm font-semibold">{{ __('15 / 50') }}</flux:text>
                    </div>
                    
                    <div class="flex justify-between items-center py-2">
                        <flux:text class="text-sm font-medium text-neutral-600 dark:text-neutral-400">{{ __('Storage Used') }}</flux:text>
                        <flux:text class="text-sm font-semibold">{{ __('2.4 GB / 10 GB') }}</flux:text>
                    </div>
                </div>
            </div>
        </div>

        <!-- Feature Access -->
        <div class="rounded-lg border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
            <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                <flux:heading size="lg">{{ __('Feature Access') }}</flux:heading>
                <flux:subheading>{{ __('Your license includes access to the following features') }}</flux:subheading>
            </div>
            
            <div class="p-6">
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    <!-- Channel Management -->
                    <div class="flex items-start space-x-3 p-4 rounded-lg border border-neutral-200 dark:border-neutral-700">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/20">
                            <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <flux:text class="font-medium">{{ __('Channel Management') }}</flux:text>
                            <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Unlimited channels with logo support') }}</flux:text>
                        </div>
                    </div>

                    <!-- Display Management -->
                    <div class="flex items-start space-x-3 p-4 rounded-lg border border-neutral-200 dark:border-neutral-700">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900/20">
                            <svg class="h-5 w-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <flux:text class="font-medium">{{ __('Display Management') }}</flux:text>
                            <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Up to 25 connected displays') }}</flux:text>
                        </div>
                    </div>

                    <!-- Template System -->
                    <div class="flex items-start space-x-3 p-4 rounded-lg border border-neutral-200 dark:border-neutral-700">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-900/20">
                            <svg class="h-5 w-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                            </svg>
                        </div>
                        <div>
                            <flux:text class="font-medium">{{ __('Template System') }}</flux:text>
                            <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('50 custom templates with drag & drop') }}</flux:text>
                        </div>
                    </div>

                    <!-- Plugin Store -->
                    <div class="flex items-start space-x-3 p-4 rounded-lg border border-neutral-200 dark:border-neutral-700">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-orange-100 dark:bg-orange-900/20">
                            <svg class="h-5 w-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <div>
                            <flux:text class="font-medium">{{ __('Plugin Store') }}</flux:text>
                            <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Access to premium plugins and integrations') }}</flux:text>
                        </div>
                    </div>

                    <!-- User Management -->
                    <div class="flex items-start space-x-3 p-4 rounded-lg border border-neutral-200 dark:border-neutral-700">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100 dark:bg-indigo-900/20">
                            <svg class="h-5 w-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                        </div>
                        <div>
                            <flux:text class="font-medium">{{ __('User Management') }}</flux:text>
                            <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Up to 50 users with role-based access') }}</flux:text>
                        </div>
                    </div>

                    <!-- Analytics -->
                    <div class="flex items-start space-x-3 p-4 rounded-lg border border-neutral-200 dark:border-neutral-700">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-100 dark:bg-red-900/20">
                            <svg class="h-5 w-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div>
                            <flux:text class="font-medium">{{ __('Analytics & Reporting') }}</flux:text>
                            <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Advanced analytics and custom reports') }}</flux:text>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Support Information -->
        <div class="rounded-lg border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <flux:heading size="lg" class="mb-4">{{ __('Support & Contact') }}</flux:heading>
            
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <flux:text class="font-medium mb-2">{{ __('Technical Support') }}</flux:text>
                    <flux:text class="text-sm text-neutral-500 dark:text-neutral-400 mb-1">{{ __('Email: support@innstream.com') }}</flux:text>
                    <flux:text class="text-sm text-neutral-500 dark:text-neutral-400 mb-1">{{ __('Phone: +1 (555) 123-4567') }}</flux:text>
                    <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Hours: 24/7 Enterprise Support') }}</flux:text>
                </div>
                
                <div>
                    <flux:text class="font-medium mb-2">{{ __('License Renewal') }}</flux:text>
                    <flux:text class="text-sm text-neutral-500 dark:text-neutral-400 mb-1">{{ __('Your license expires on December 31, 2025') }}</flux:text>
                    <flux:text class="text-sm text-neutral-500 dark:text-neutral-400 mb-1">{{ __('Contact sales@innstream.com for renewal') }}</flux:text>
                    <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Early renewal discounts available') }}</flux:text>
                </div>
            </div>
        </div>
    </div>

    <!-- Activate License Modal -->
    <flux:modal name="activate-license-modal" class="max-w-md">
        <div class="p-6">
            <div class="mb-6">
                <flux:heading size="lg">{{ __('Activate License') }}</flux:heading>
                <flux:subheading>{{ __('Enter your INNSTREAM IPTV license key to activate your account') }}</flux:subheading>
            </div>

            <form wire:submit="activateLicense" class="space-y-6">
                <!-- License Key Input -->
                <flux:field>
                    <flux:label for="licenseKey">{{ __('License Key') }}</flux:label>
                    <flux:input 
                        id="licenseKey" 
                        wire:model="licenseKey" 
                        placeholder="{{ __('XXXX-XXXX-XXXX-XXXX') }}"
                        class="font-mono text-center tracking-widest"
                        maxlength="19"
                        required
                    />
                    <flux:subheading>{{ __('Enter your 16-character license key in the format shown above') }}</flux:subheading>
                </flux:field>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                    <flux:modal.close>
                        <flux:button variant="subtle">{{ __('Cancel') }}</flux:button>
                    </flux:modal.close>
                    <flux:button variant="primary" type="submit" wire:loading.attr="disabled" wire:loading.class="opacity-50">
                        <div wire:loading.remove>
                            {{ __('Activate License') }}
                        </div>
                        <div wire:loading>
                            <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            {{ __('Activating...') }}
                        </div>
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>