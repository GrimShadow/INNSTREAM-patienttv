<?php

use App\Models\PermissionCategory;
use function Livewire\Volt\{with, layout, title};

layout('components.layouts.app');
title(__('Permission Categories'));

// Provide data to view
with(fn () => [
    'categories' => PermissionCategory::withCount('permissions')->orderBy('name')->get(),
    'totalCategories' => PermissionCategory::count(),
    'totalPermissions' => PermissionCategory::withCount('permissions')->get()->sum('permissions_count'),
]);

// Form properties
$name = '';
$description = '';
$color = '#6B7280';

// Add category function
$addCategory = function() use ($name, $description, $color) {
    $validated = validator([
        'name' => $name,
        'description' => $description,
        'color' => $color,
    ], [
        'name' => 'required|string|max:255|unique:permission_categories,name',
        'description' => 'nullable|string|max:500',
        'color' => 'required|string|regex:/^#[0-9A-F]{6}$/i',
    ])->validate();
    
    PermissionCategory::create($validated);
    
    // Reset form by redirecting
    $this->redirect(route('permission-categories'));
};

// Delete category function
$deleteCategory = function($categoryId) {
    $category = PermissionCategory::find($categoryId);
    if ($category) {
        // Check if category has permissions
        if ($category->permissions()->count() > 0) {
            // Don't delete if it has permissions
            return;
        }
        $category->delete();
        $this->redirect(route('permission-categories'));
    }
};

?>

<div>
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="2xl">{{ __('Permission Categories') }}</flux:heading>
                <flux:subheading>{{ __('Organize permissions into categories for better management') }}</flux:subheading>
            </div>
            <flux:modal.trigger name="add-category-modal">
                <flux:button variant="primary">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    {{ __('Add Category') }}
                </flux:button>
            </flux:modal.trigger>
        </div>

        <!-- Stats -->
        <div class="grid gap-4 md:grid-cols-2">
            <div class="rounded-lg border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/20">
                        <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <flux:text class="text-sm font-medium text-neutral-500 dark:text-neutral-400">{{ __('Total Categories') }}</flux:text>
                        <flux:text class="text-2xl font-bold">{{ $totalCategories }}</flux:text>
                    </div>
                </div>
            </div>

            <div class="rounded-lg border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900/20">
                        <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <flux:text class="text-sm font-medium text-neutral-500 dark:text-neutral-400">{{ __('Total Permissions') }}</flux:text>
                        <flux:text class="text-2xl font-bold">{{ $totalPermissions }}</flux:text>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Table -->
        <div class="rounded-lg border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-neutral-200 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                {{ __('Category') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                {{ __('Description') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                {{ __('Permissions') }}
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
                        @foreach($categories as $category)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg mr-3" 
                                         style="background-color: {{ $category->color }}20;">
                                        <div class="w-4 h-4 rounded-full" style="background-color: {{ $category->color }};"></div>
                                    </div>
                                    <div>
                                        <flux:text class="text-sm font-medium">{{ $category->name }}</flux:text>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ $category->description ?: __('No description') }}</flux:text>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400">
                                    {{ $category->permissions_count }} {{ __('permissions') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ $category->created_at->format('M j, Y') }}</flux:text>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    @if($category->permissions_count === 0)
                                        <flux:button variant="subtle" size="sm" icon="trash" wire:click="deleteCategory({{ $category->id }})" wire:confirm="{{ __('Are you sure you want to delete this category?') }}">
                                            {{ __('Delete') }}
                                        </flux:button>
                                    @else
                                        <flux:text class="text-xs text-neutral-400 dark:text-neutral-500">{{ __('Cannot delete - has permissions') }}</flux:text>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Category Modal -->
    <flux:modal name="add-category-modal" class="max-w-2xl">
        <div class="p-6">
            <div class="mb-6">
                <flux:heading size="lg">{{ __('Add New Category') }}</flux:heading>
                <flux:subheading>{{ __('Create a new permission category') }}</flux:subheading>
            </div>

            <form wire:submit="addCategory" class="space-y-6">
                <!-- Category Name -->
                <flux:field>
                    <flux:label for="name">{{ __('Category Name') }}</flux:label>
                    <flux:input 
                        id="name" 
                        wire:model="name" 
                        placeholder="{{ __('Enter category name') }}"
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
                        placeholder="{{ __('Enter category description (optional)') }}"
                    />
                    @error('description') 
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:field>

                <!-- Color -->
                <flux:field>
                    <flux:label for="color">{{ __('Color') }}</flux:label>
                    <div class="flex items-center space-x-3">
                        <input type="color" 
                               id="color" 
                               wire:model="color" 
                               class="h-10 w-20 rounded border border-neutral-300 dark:border-neutral-600"
                               required>
                        <flux:input 
                            wire:model="color" 
                            placeholder="#6B7280"
                            class="flex-1"
                            required
                        />
                    </div>
                    @error('color') 
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:field>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                    <flux:modal.close>
                        <flux:button variant="subtle">{{ __('Cancel') }}</flux:button>
                    </flux:modal.close>
                    <flux:button variant="primary" type="submit">
                        {{ __('Create Category') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div> 