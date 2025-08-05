<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::redirect('/', '/login');

Volt::route('dashboard', 'dashboard')
    ->middleware(['auth'])
    ->name('dashboard');

Route::view('display-management', 'display-management')
    ->middleware(['auth'])
    ->name('display-management');

Route::view('template-management', 'template-management')
    ->middleware(['auth'])
    ->name('template-management');

Route::view('templates', 'templates')
    ->middleware(['auth'])
    ->name('templates');

Route::view('template-ui', 'template-ui')
    ->middleware(['auth'])
    ->name('template-ui');

Volt::route('channel-management', 'channel-management')
    ->middleware(['auth'])
    ->name('channel-management');

Route::view('plugins', 'plugins')
    ->middleware(['auth'])
    ->name('plugins');

Volt::route('reporting-analytics', 'reporting-analytics')
    ->middleware(['auth'])
    ->name('reporting-analytics');

Volt::route('license', 'license')
    ->middleware(['auth'])
    ->name('license');

Volt::route('users', 'users')
    ->middleware(['auth'])
    ->name('users');

Volt::route('roles', 'roles')
    ->middleware(['auth'])
    ->name('roles');

Volt::route('permissions', 'permissions')
    ->middleware(['auth'])
    ->name('permissions');

Volt::route('permission-categories', 'permission-categories')
    ->middleware(['auth'])
    ->name('permission-categories');

Route::view('settings', 'settings')
    ->middleware(['auth'])
    ->name('settings');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
