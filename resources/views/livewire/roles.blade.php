<?php

use App\Models\User;
use App\Models\Role;
use function Livewire\Volt\{with, layout, title};
use Livewire\Attributes\Rule;

layout('components.layouts.app');
title(__('Roles'));

// Provide data to view
with(fn () => [
    'roles' => Role::with('users')->orderBy('name')->get(),
    'users' => User::orderBy('name')->get(),
    'totalRoles' => Role::count(),
    'totalUsers' => User::count(),
    'assignedUsers' => User::whereHas('roles')->count(),
]);

// Form properties
$name = '';
$description = '';
$selectedUsers = [];



// Add role function
$addRole = function() use ($name, $description, $selectedUsers) {
    // Manual validation since we're using functional Volt
    $validated = validator([
        'name' => $name,
        'description' => $description,
        'selectedUsers' => $selectedUsers,
    ], [
        'name' => 'required|string|max:255|unique:roles,name',
        'description' => 'nullable|string|max:500',
        'selectedUsers' => 'array',
    ])->validate();
    
    $role = Role::create([
        'name' => $validated['name'],
        'description' => $validated['description'],
    ]);
    
    if (!empty($validated['selectedUsers'])) {
        $role->users()->attach($validated['selectedUsers']);
    }
    
    // Reset form by redirecting
    $this->redirect(route('roles'));
};

// Delete role function
$deleteRole = function($roleId) {
    $role = Role::find($roleId);
    if ($role) {
        $role->users()->detach();
        $role->delete();
        $this->redirect(route('roles'));
    }
};

// Assign users to role function
$assignUsers = function($roleId, $userIds) {
    $role = Role::find($roleId);
    if ($role) {
        $role->users()->sync($userIds);
        $this->redirect(route('roles'));
    }
};

?>

<div> <!-- Single root element -->
    <div class="flex h-full w-full flex-1 flex-col gap-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="2xl">{{ __('Roles') }}</flux:heading>
            <flux:subheading>{{ __('Manage user roles and permissions') }}</flux:subheading>
        </div>
        <flux:modal.trigger name="add-role-modal">
            <flux:button variant="primary">
            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            {{ __('Add Role') }}
            </flux:button>
        </flux:modal.trigger>
    </div>

    <!-- Stats -->
    <div class="grid gap-4 md:grid-cols-3">
        <div class="rounded-lg border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-center">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/20">
                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <flux:text class="text-sm font-medium text-neutral-500 dark:text-neutral-400">{{ __('Total Roles') }}</flux:text>
                    <flux:text class="text-2xl font-bold">{{ $totalRoles }}</flux:text>
                </div>
            </div>
        </div>

        <div class="rounded-lg border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-center">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900/20">
                    <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-900/20">
                    <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <flux:text class="text-sm font-medium text-neutral-500 dark:text-neutral-400">{{ __('Assigned Users') }}</flux:text>
                    <flux:text class="text-2xl font-bold">{{ $assignedUsers }}</flux:text>
                </div>
            </div>
        </div>
    </div>

    <!-- Roles Table -->
    <div class="rounded-lg border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="border-b border-neutral-200 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                            {{ __('Role') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                            {{ __('Description') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                            {{ __('Users') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                            {{ __('Created') }}
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                    @foreach($roles as $role)
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-900/20">
                                    <svg class="h-5 w-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <flux:text class="text-sm font-medium">{{ $role->name }}</flux:text>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ $role->description ?: __('No description') }}</flux:text>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <flux:text class="text-sm font-medium">{{ $role->users->count() }}</flux:text>
                                @if($role->users->count() > 0)
                                    <flux:text class="text-sm text-neutral-500 dark:text-neutral-400 ml-2">
                                        ({{ $role->users->take(3)->pluck('name')->implode(', ') }}{{ $role->users->count() > 3 ? '...' : '' }})
                                    </flux:text>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ $role->created_at->format('M j, Y') }}</flux:text>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <flux:modal.trigger name="assign-users-modal-{{ $role->id }}">
                                    <flux:button variant="subtle" size="sm">
                                        {{ __('Assign Users') }}
                                    </flux:button>
                                </flux:modal.trigger>
                                <flux:button variant="subtle" size="sm" icon="trash" wire:click="deleteRole({{ $role->id }})" wire:confirm="{{ __('Are you sure you want to delete this role?') }}">
                                    {{ __('Delete') }}
                                </flux:button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Role Modal -->
<flux:modal name="add-role-modal" class="max-w-4xl">
    <div class="p-6">
        <div class="mb-6">
            <flux:heading size="lg">{{ __('Add New Role') }}</flux:heading>
            <flux:subheading>{{ __('Create a new role and assign users') }}</flux:subheading>
        </div>

        <form wire:submit="addRole" class="space-y-6">
            <!-- Role Name -->
            <flux:field>
                <flux:label for="name">{{ __('Role Name') }}</flux:label>
                <flux:input 
                    id="name" 
                    wire:model="name" 
                    placeholder="{{ __('Enter role name (e.g., Administrator, Manager)') }}"
                    required
                />
                @error('name') 
                    <flux:error>{{ $message }}</flux:error>
                @enderror
            </flux:field>

            <!-- Description -->
            <flux:field>
                <flux:label for="description">{{ __('Description') }}</flux:label>
                <flux:input 
                    id="description" 
                    wire:model="description" 
                    placeholder="{{ __('Enter role description (optional)') }}"
                />
                @error('description') 
                    <flux:error>{{ $message }}</flux:error>
                @enderror
            </flux:field>

            <!-- Assign Users -->
            <flux:field>
                <flux:label>{{ __('Assign Users') }}</flux:label>
                <flux:subheading class="mb-3">{{ __('Select users to assign to this role') }}</flux:subheading>
                
                <div class="space-y-2 max-h-48 overflow-y-auto border border-neutral-200 rounded-lg p-3 dark:border-neutral-700">
                    @foreach($users as $user)
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" 
                               wire:model="selectedUsers" 
                               value="{{ $user->id }}"
                               class="rounded border-neutral-300 text-blue-600 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800">
                        <div class="flex items-center">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/20 mr-3">
                                <flux:text class="text-xs font-medium text-blue-600 dark:text-blue-400">{{ $user->initials() }}</flux:text>
                            </div>
                            <div>
                                <flux:text class="text-sm font-medium">{{ $user->name }}</flux:text>
                                <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ $user->email }}</flux:text>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('selectedUsers') 
                    <flux:error>{{ $message }}</flux:error>
                @enderror
            </flux:field>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                <flux:modal.close>
                    <flux:button variant="subtle">{{ __('Cancel') }}</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" type="submit">
                    {{ __('Add Role') }}
                </flux:button>
            </div>
        </form>
    </div>
</flux:modal>

<!-- Assign Users Modals for each role -->
@foreach($roles as $role)
<flux:modal name="assign-users-modal-{{ $role->id }}" class="max-w-4xl">
    <div class="p-6">
        <div class="mb-6">
            <flux:heading size="lg">{{ __('Assign Users to') }} {{ $role->name }}</flux:heading>
            <flux:subheading>{{ __('Select users to assign to this role') }}</flux:subheading>
        </div>

        <form wire:submit="assignUsers({{ $role->id }}, $event.target.selectedUsers.value)" class="space-y-6">
            <flux:field>
                <flux:label>{{ __('Select Users') }}</flux:label>
                <div class="space-y-2 max-h-64 overflow-y-auto border border-neutral-200 rounded-lg p-3 dark:border-neutral-700">
                    @foreach($users as $user)
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" 
                               name="selectedUsers[]"
                               value="{{ $user->id }}"
                               {{ $role->users->contains($user->id) ? 'checked' : '' }}
                               class="rounded border-neutral-300 text-blue-600 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800">
                        <div class="flex items-center">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/20 mr-3">
                                <flux:text class="text-xs font-medium text-blue-600 dark:text-blue-400">{{ $user->initials() }}</flux:text>
                            </div>
                            <div>
                                <flux:text class="text-sm font-medium">{{ $user->name }}</flux:text>
                                <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ $user->email }}</flux:text>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>
            </flux:field>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                <flux:modal.close>
                    <flux:button variant="subtle">{{ __('Cancel') }}</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" type="submit">
                    {{ __('Update Assignments') }}
                </flux:button>
            </div>
        </form>
    </div>
</flux:modal>
@endforeach
</div>