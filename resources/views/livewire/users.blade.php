<?php

use App\Models\User;
use function Livewire\Volt\{with, layout, title};
use Livewire\Attributes\Rule;

layout('components.layouts.app');
title(__('Users'));

// Provide data to view
with(fn () => [
    'users' => User::orderBy('name')->get(),
    'totalUsers' => User::count(),
    'activeUsers' => User::where('email_verified_at', '!=', null)->count(),
    'pendingUsers' => User::where('email_verified_at', null)->count(),
]);

// Form properties
$name = '';
$email = '';
$password = '';

// Validation rules
$rules = [
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users,email',
    'password' => ['required', \Illuminate\Validation\Rules\Password::defaults()],
];

// Add user function
$addUser = function() use ($name, $email, $password) {
    $this->validate();
    
    User::create([
        'name' => $name,
        'email' => $email,
        'password' => \Illuminate\Support\Facades\Hash::make($password),
    ]);
    
    $this->reset(['name', 'email', 'password']);
    $this->redirect(route('users'));
};

// Delete user function
$deleteUser = function($userId) {
    $user = User::find($userId);
    if ($user && $user->id !== auth()->id()) {
        $user->delete();
        $this->redirect(route('users'));
    }
};

?>

<div>
    <div class="flex h-full w-full flex-1 flex-col gap-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="2xl">{{ __('Users') }}</flux:heading>
            <flux:subheading>{{ __('Manage system users and permissions') }}</flux:subheading>
        </div>
        <flux:modal.trigger name="add-user-modal">
            <flux:button variant="primary">
            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            {{ __('Add User') }}
            </flux:button>
        </flux:modal.trigger>
    </div>

    <!-- Stats -->
    <div class="grid gap-4 md:grid-cols-3">
        <div class="rounded-lg border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-center">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/20">
                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <flux:text class="text-sm font-medium text-neutral-500 dark:text-neutral-400">{{ __('Total Users') }}</flux:text>
                    <flux:text class="text-2xl font-bold">{{ $totalUsers }}</flux:text>
                </div>
            </div>
        </div>

        <div class="rounded-lg border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-center">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900/20">
                    <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <flux:text class="text-sm font-medium text-neutral-500 dark:text-neutral-400">{{ __('Active Users') }}</flux:text>
                    <flux:text class="text-2xl font-bold">{{ $activeUsers }}</flux:text>
                </div>
            </div>
        </div>

        <div class="rounded-lg border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-center">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-yellow-100 dark:bg-yellow-900/20">
                    <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <flux:text class="text-sm font-medium text-neutral-500 dark:text-neutral-400">{{ __('Pending Verification') }}</flux:text>
                    <flux:text class="text-2xl font-bold">{{ $pendingUsers }}</flux:text>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="rounded-lg border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="border-b border-neutral-200 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                            {{ __('User') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                            {{ __('Email') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                            {{ __('Status') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                            {{ __('Joined') }}
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                    @foreach($users as $user)
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/20">
                                    <flux:text class="text-sm font-medium text-blue-600 dark:text-blue-400">{{ $user->initials() }}</flux:text>
                                </div>
                                <div class="ml-4">
                                    <flux:text class="text-sm font-medium">{{ $user->name }}</flux:text>
                                    @if($user->id === auth()->id())
                                        <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('(You)') }}</flux:text>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <flux:text class="text-sm">{{ $user->email }}</flux:text>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                @if($user->email_verified_at)
                                    <div class="h-2 w-2 rounded-full bg-green-500"></div>
                                    <flux:text class="text-sm text-green-600 dark:text-green-400">{{ __('Verified') }}</flux:text>
                                @else
                                    <div class="h-2 w-2 rounded-full bg-yellow-500"></div>
                                    <flux:text class="text-sm text-yellow-600 dark:text-yellow-400">{{ __('Pending') }}</flux:text>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ $user->created_at->format('M j, Y') }}</flux:text>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            @if($user->id !== auth()->id())
                                <flux:button variant="subtle" size="sm" icon="trash" wire:click="deleteUser({{ $user->id }})" wire:confirm="{{ __('Are you sure you want to delete this user?') }}">
                                    {{ __('Delete') }}
                                </flux:button>
                            @else
                                <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Current User') }}</flux:text>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<flux:modal name="add-user-modal" class="max-w-2xl">
    <div class="p-6">
        <div class="mb-6">
            <flux:heading size="lg">{{ __('Add New User') }}</flux:heading>
            <flux:subheading>{{ __('Create a new user account for the system') }}</flux:subheading>
        </div>

        <form wire:submit="addUser" class="space-y-6">
            <!-- Name Field -->
            <flux:field>
                <flux:label for="name">{{ __('Full Name') }}</flux:label>
                <flux:input 
                    id="name" 
                    wire:model="name" 
                    placeholder="{{ __('Enter the user\'s full name') }}"
                    required
                />
                @error('name') 
                    <flux:error>{{ $message }}</flux:error>
                @enderror
            </flux:field>

            <!-- Email Field -->
            <flux:field>
                <flux:label for="email">{{ __('Email Address') }}</flux:label>
                <flux:input 
                    id="email" 
                    type="email"
                    wire:model="email" 
                    placeholder="{{ __('Enter a valid email address') }}"
                    required
                />
                @error('email') 
                    <flux:error>{{ $message }}</flux:error>
                @enderror
            </flux:field>

            <!-- Password Field -->
            <flux:field>
                <flux:label for="password">{{ __('Password') }}</flux:label>
                <flux:input 
                    id="password" 
                    type="password"
                    wire:model="password" 
                    placeholder="{{ __('Enter a secure password') }}"
                    required
                />
                <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('Password must be at least 8 characters long') }}
                </flux:text>
                @error('password') 
                    <flux:error>{{ $message }}</flux:error>
                @enderror
            </flux:field>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                <flux:modal.close>
                    <flux:button variant="subtle">{{ __('Cancel') }}</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" type="submit">
                    {{ __('Add User') }}
                </flux:button>
            </div>
        </form>
    </div>
</flux:modal>
</div> 