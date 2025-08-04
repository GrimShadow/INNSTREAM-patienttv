<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\PermissionCategory;
use function Livewire\Volt\{with, layout, title};

layout('components.layouts.app');
title(__('Permissions'));

// Provide data to view
with(fn () => [
    'permissions' => Permission::with(['roles', 'users', 'categories'])->orderBy('name')->get(),
    'roles' => Role::orderBy('name')->get(),
    'users' => User::orderBy('name')->get(),
    'categories' => PermissionCategory::orderBy('name')->get(),
    'totalPermissions' => Permission::count(),
    'totalRoles' => Role::count(),
    'totalUsers' => User::count(),
    'assignedPermissions' => Permission::whereHas('roles')->orWhereHas('users')->count(),
]);

// Form properties
$name = '';
$description = '';
$selectedCategories = [];
$selectedRoles = [];
$selectedUsers = [];

// Add permission function
$addPermission = function() use ($name, $description, $selectedCategories, $selectedRoles, $selectedUsers) {
    // Manual validation since we're using functional Volt
    $validated = validator([
        'name' => $name,
        'description' => $description,
        'selectedCategories' => $selectedCategories,
        'selectedRoles' => $selectedRoles,
        'selectedUsers' => $selectedUsers,
    ], [
        'name' => 'required|string|max:255|unique:permissions,name',
        'description' => 'nullable|string|max:500',
        'selectedCategories' => 'required|array|min:1',
        'selectedRoles' => 'array',
        'selectedUsers' => 'array',
    ])->validate();
    
    $permission = Permission::create([
        'name' => $validated['name'],
        'description' => $validated['description'],
    ]);
    
    if (!empty($validated['selectedCategories'])) {
        $permission->categories()->attach($validated['selectedCategories']);
    }
    
    if (!empty($validated['selectedRoles'])) {
        $permission->roles()->attach($validated['selectedRoles']);
    }
    
    if (!empty($validated['selectedUsers'])) {
        $permission->users()->attach($validated['selectedUsers']);
    }
    
    // Reset form by redirecting
    $this->redirect(route('permissions'));
};

// Delete permission function
$deletePermission = function($permissionId) {
    $permission = Permission::find($permissionId);
    if ($permission) {
        $permission->roles()->detach();
        $permission->users()->detach();
        $permission->delete();
        $this->redirect(route('permissions'));
    }
};

// Assign roles to permission function
$assignRoles = function($permissionId, $roleIds) {
    $permission = Permission::find($permissionId);
    if ($permission) {
        $permission->roles()->sync($roleIds);
        $this->redirect(route('permissions'));
    }
};

// Assign users to permission function
$assignUsers = function($permissionId, $userIds) {
    $permission = Permission::find($permissionId);
    if ($permission) {
        $permission->users()->sync($userIds);
        $this->redirect(route('permissions'));
    }
};

?>

<div> <!-- Single root element -->
    <div class="flex h-full w-full flex-1 flex-col gap-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="2xl">{{ __('Permissions') }}</flux:heading>
            <flux:subheading>{{ __('Manage system permissions and access control') }}</flux:subheading>
        </div>
        <flux:modal.trigger name="add-permission-modal">
            <flux:button variant="primary">
            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            {{ __('Add Permission') }}
            </flux:button>
        </flux:modal.trigger>
    </div>

    <!-- Stats -->
    <div class="grid gap-4 md:grid-cols-4">
        <div class="rounded-lg border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-center">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/20">
                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <flux:text class="text-sm font-medium text-neutral-500 dark:text-neutral-400">{{ __('Total Permissions') }}</flux:text>
                    <flux:text class="text-2xl font-bold">{{ $totalPermissions }}</flux:text>
                </div>
            </div>
        </div>

        <div class="rounded-lg border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-center">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900/20">
                    <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-900/20">
                    <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-orange-100 dark:bg-orange-900/20">
                    <svg class="h-6 w-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <flux:text class="text-sm font-medium text-neutral-500 dark:text-neutral-400">{{ __('Assigned Permissions') }}</flux:text>
                    <flux:text class="text-2xl font-bold">{{ $assignedPermissions }}</flux:text>
                </div>
            </div>
        </div>
    </div>

    <!-- Permissions Table -->
    <div class="rounded-lg border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="border-b border-neutral-200 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                            {{ __('Permission') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                            {{ __('Category') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                            {{ __('Description') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                            {{ __('Assigned To') }}
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
                    @foreach($permissions as $permission)
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-orange-100 dark:bg-orange-900/20">
                                    <svg class="h-5 w-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <flux:text class="text-sm font-medium">{{ $permission->name }}</flux:text>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-wrap gap-1">
                                @forelse($permission->categories as $category)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" 
                                          style="background-color: {{ $category->color }}20; color: {{ $category->color }};">
                                        {{ $category->name }}
                                    </span>
                                @empty
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-neutral-100 text-neutral-600 dark:bg-neutral-700 dark:text-neutral-400">
                                        {{ __('No Category') }}
                                    </span>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ $permission->description ?: __('No description') }}</flux:text>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="space-y-1">
                                @if($permission->roles->count() > 0)
                                    <div class="flex items-center">
                                        <flux:text class="text-xs text-neutral-500 dark:text-neutral-400 mr-2">{{ __('Roles:') }}</flux:text>
                                        <flux:text class="text-sm">{{ $permission->roles->take(2)->pluck('name')->implode(', ') }}{{ $permission->roles->count() > 2 ? '...' : '' }}</flux:text>
                                    </div>
                                @endif
                                @if($permission->users->count() > 0)
                                    <div class="flex items-center">
                                        <flux:text class="text-xs text-neutral-500 dark:text-neutral-400 mr-2">{{ __('Users:') }}</flux:text>
                                        <flux:text class="text-sm">{{ $permission->users->take(2)->pluck('name')->implode(', ') }}{{ $permission->users->count() > 2 ? '...' : '' }}</flux:text>
                                    </div>
                                @endif
                                @if($permission->roles->count() === 0 && $permission->users->count() === 0)
                                    <flux:text class="text-sm text-neutral-400 dark:text-neutral-500">{{ __('Not assigned') }}</flux:text>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ $permission->created_at->format('M j, Y') }}</flux:text>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <flux:modal.trigger name="assign-roles-modal-{{ $permission->id }}">
                                    <flux:button variant="subtle" size="sm">
                                        {{ __('Assign Roles') }}
                                    </flux:button>
                                </flux:modal.trigger>
                                <flux:modal.trigger name="assign-users-modal-{{ $permission->id }}">
                                    <flux:button variant="subtle" size="sm">
                                        {{ __('Assign Users') }}
                                    </flux:button>
                                </flux:modal.trigger>
                                <flux:button variant="subtle" size="sm" icon="trash" wire:click="deletePermission({{ $permission->id }})" wire:confirm="{{ __('Are you sure you want to delete this permission?') }}">
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

    <!-- Add Permission Modal -->
<flux:modal name="add-permission-modal" class="max-w-4xl">
    <div class="p-6">
        <div class="mb-6">
            <flux:heading size="lg">{{ __('Add New Permission') }}</flux:heading>
            <flux:subheading>{{ __('Create a new permission and assign it to roles or users') }}</flux:subheading>
        </div>

        <form wire:submit="addPermission" class="space-y-6">
            <!-- Permission Name -->
            <flux:field>
                <flux:label for="name">{{ __('Permission Name') }}</flux:label>
                <flux:input 
                    id="name" 
                    wire:model="name" 
                    placeholder="{{ __('Enter permission name (e.g., view_channels, manage_users)') }}"
                    required
                />
                @error('name') 
                    <flux:error>{{ $message }}</flux:error>
                @enderror
            </flux:field>

            <!-- Categories -->
            <flux:field>
                <flux:label>{{ __('Categories') }}</flux:label>
                <flux:subheading class="mb-3">{{ __('Select one or more categories for this permission') }}</flux:subheading>
                
                <div class="space-y-2 max-h-32 overflow-y-auto border border-neutral-200 rounded-lg p-3 dark:border-neutral-700">
                    @foreach($categories as $category)
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" 
                               wire:model="selectedCategories" 
                               value="{{ $category->id }}"
                               class="rounded border-neutral-300 text-blue-600 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800">
                        <div class="flex items-center">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg mr-3" 
                                 style="background-color: {{ $category->color }}20;">
                                <div class="w-3 h-3 rounded-full" style="background-color: {{ $category->color }};"></div>
                            </div>
                            <div>
                                <flux:text class="text-sm font-medium">{{ $category->name }}</flux:text>
                                <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ $category->description ?: __('No description') }}</flux:text>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('selectedCategories') 
                    <flux:error>{{ $message }}</flux:error>
                @enderror
            </flux:field>

            <!-- Description -->
            <flux:field>
                <flux:label for="description">{{ __('Description') }}</flux:label>
                <flux:input 
                    id="description" 
                    wire:model="description" 
                    placeholder="{{ __('Enter permission description (optional)') }}"
                />
                @error('description') 
                    <flux:error>{{ $message }}</flux:error>
                @enderror
            </flux:field>

            <!-- Assign Roles -->
            <flux:field>
                <flux:label>{{ __('Assign to Roles') }}</flux:label>
                <flux:subheading class="mb-3">{{ __('Select roles to assign this permission to') }}</flux:subheading>
                
                <div class="space-y-2 max-h-32 overflow-y-auto border border-neutral-200 rounded-lg p-3 dark:border-neutral-700">
                    @foreach($roles as $role)
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" 
                               wire:model="selectedRoles" 
                               value="{{ $role->id }}"
                               class="rounded border-neutral-300 text-blue-600 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800">
                        <div class="flex items-center">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-900/20 mr-3">
                                <svg class="h-4 w-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <flux:text class="text-sm font-medium">{{ $role->name }}</flux:text>
                                <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ $role->description ?: __('No description') }}</flux:text>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('selectedRoles') 
                    <flux:error>{{ $message }}</flux:error>
                @enderror
            </flux:field>

            <!-- Assign Users -->
            <flux:field>
                <flux:label>{{ __('Assign to Users') }}</flux:label>
                <flux:subheading class="mb-3">{{ __('Select users to assign this permission to directly') }}</flux:subheading>
                
                <div class="space-y-2 max-h-32 overflow-y-auto border border-neutral-200 rounded-lg p-3 dark:border-neutral-700">
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
                    {{ __('Add Permission') }}
                </flux:button>
            </div>
        </form>
    </div>
</flux:modal>

<!-- Assign Roles Modals for each permission -->
@foreach($permissions as $permission)
<flux:modal name="assign-roles-modal-{{ $permission->id }}" class="max-w-2xl">
    <div class="p-6">
        <div class="mb-6">
            <flux:heading size="lg">{{ __('Assign Roles to') }} {{ $permission->name }}</flux:heading>
            <flux:subheading>{{ __('Select roles to assign this permission to') }}</flux:subheading>
        </div>

        <form wire:submit="assignRoles({{ $permission->id }}, $event.target.selectedRoles.value)" class="space-y-6">
            <flux:field>
                <flux:label>{{ __('Select Roles') }}</flux:label>
                <div class="space-y-2 max-h-64 overflow-y-auto border border-neutral-200 rounded-lg p-3 dark:border-neutral-700">
                    @foreach($roles as $role)
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" 
                               name="selectedRoles[]"
                               value="{{ $role->id }}"
                               {{ $permission->roles->contains($role->id) ? 'checked' : '' }}
                               class="rounded border-neutral-300 text-blue-600 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800">
                        <div class="flex items-center">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-900/20 mr-3">
                                <svg class="h-4 w-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <flux:text class="text-sm font-medium">{{ $role->name }}</flux:text>
                                <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ $role->description ?: __('No description') }}</flux:text>
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
                    {{ __('Update Role Assignments') }}
                </flux:button>
            </div>
        </form>
    </div>
</flux:modal>
@endforeach

<!-- Assign Users Modals for each permission -->
@foreach($permissions as $permission)
<flux:modal name="assign-users-modal-{{ $permission->id }}" class="max-w-2xl">
    <div class="p-6">
        <div class="mb-6">
            <flux:heading size="lg">{{ __('Assign Users to') }} {{ $permission->name }}</flux:heading>
            <flux:subheading>{{ __('Select users to assign this permission to directly') }}</flux:subheading>
        </div>

        <form wire:submit="assignUsers({{ $permission->id }}, $event.target.selectedUsers.value)" class="space-y-6">
            <flux:field>
                <flux:label>{{ __('Select Users') }}</flux:label>
                <div class="space-y-2 max-h-64 overflow-y-auto border border-neutral-200 rounded-lg p-3 dark:border-neutral-700">
                    @foreach($users as $user)
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" 
                               name="selectedUsers[]"
                               value="{{ $user->id }}"
                               {{ $permission->users->contains($user->id) ? 'checked' : '' }}
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
                    {{ __('Update User Assignments') }}
                </flux:button>
            </div>
        </form>
    </div>
</flux:modal>
@endforeach
</div>