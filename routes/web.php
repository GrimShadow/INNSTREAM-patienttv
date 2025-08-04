<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

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

Route::view('reporting-analytics', 'reporting-analytics')
    ->middleware(['auth'])
    ->name('reporting-analytics');

Route::view('integrations', 'integrations')
    ->middleware(['auth'])
    ->name('integrations');

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
