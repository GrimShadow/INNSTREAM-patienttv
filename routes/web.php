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

Route::get('templates', [App\Http\Controllers\TemplateController::class, 'index'])
    ->middleware(['auth'])
    ->name('templates');

Route::get('templates/{template}', [App\Http\Controllers\TemplateController::class, 'show'])
    ->middleware(['auth'])
    ->name('template.show');

Route::get('templates/{template}/preview', [App\Http\Controllers\TemplateController::class, 'preview'])
    ->middleware(['auth'])
    ->name('template.preview');

Route::get('templates/{template}/data', [App\Http\Controllers\TemplateController::class, 'getTemplateData'])
    ->middleware(['auth'])
    ->name('template.data');

Route::get('templates/{template}/html', [App\Http\Controllers\TemplateController::class, 'getHtml'])
    ->middleware(['auth'])
    ->name('template.html');

Route::post('templates', [App\Http\Controllers\TemplateController::class, 'store'])
    ->middleware(['auth'])
    ->name('template.store');

Route::put('templates/{template}', [App\Http\Controllers\TemplateController::class, 'update'])
    ->middleware(['auth'])
    ->name('template.update');

Route::post('templates/{template}/deploy', [App\Http\Controllers\TemplateController::class, 'deploy'])
    ->middleware(['auth'])
    ->name('template.deploy');

Route::get('templates/categories', [App\Http\Controllers\TemplateController::class, 'getCategories'])
    ->middleware(['auth'])
    ->name('template.categories');

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
