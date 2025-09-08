<?php

use App\Events\TestEvent;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::redirect('/', '/login');

Volt::route('dashboard', 'dashboard')
    ->middleware(['auth'])
    ->name('dashboard');

Route::view('display-management', 'display-management')
    ->middleware(['auth'])
    ->name('display-management');

// WebSocket test page (remove in production)
Route::view('websocket-test', 'websocket-test');

// Test broadcast route (remove in production)
Route::get('test-broadcast', function () {
    broadcast(new TestEvent('Test message from server!'));

    return 'Event broadcasted!';
});

Route::get('template-management', [App\Http\Controllers\TemplateController::class, 'management'])
    ->middleware(['auth'])
    ->name('template-management');

Route::get('templates', [App\Http\Controllers\TemplateController::class, 'index'])
    ->middleware(['auth'])
    ->name('templates');

Route::post('templates/deploy', [App\Http\Controllers\TemplateController::class, 'deploy'])
    ->middleware(['auth'])
    ->name('templates.deploy');

Route::delete('templates/deployments/{deployment}/remove', [App\Http\Controllers\TemplateController::class, 'remove'])
    ->middleware(['auth'])
    ->name('templates.deployments.remove');

// Specific routes must come before parameterized routes
Route::post('templates/upload', [App\Http\Controllers\TemplateController::class, 'upload'])
    ->middleware(['auth'])
    ->name('template.upload');

Route::post('templates', [App\Http\Controllers\TemplateController::class, 'store'])
    ->middleware(['auth'])
    ->name('template.store');

Route::get('templates/{template}', [App\Http\Controllers\TemplateController::class, 'show'])
    ->middleware(['auth'])
    ->name('template.show');

Route::get('templates/{template}/preview', [App\Http\Controllers\TemplateController::class, 'preview'])
    ->name('template.preview');

Route::get('templates/{template}/data', [App\Http\Controllers\TemplateController::class, 'getTemplateData'])
    ->middleware(['auth'])
    ->name('template.data');

Route::get('templates/{template}/html', [App\Http\Controllers\TemplateController::class, 'getHtml'])
    ->middleware(['auth'])
    ->name('template.html');

Route::get('templates/{template}/css', [App\Http\Controllers\TemplateController::class, 'getCss'])
    ->name('template.css');

Route::get('templates/{template}/js', [App\Http\Controllers\TemplateController::class, 'getJs'])
    ->name('template.js');

Route::get('templates/{template}/assets/{path?}', [App\Http\Controllers\TemplateController::class, 'assets'])
    ->where('path', '.*')
    ->name('template.assets');

Route::put('templates/{template}', [App\Http\Controllers\TemplateController::class, 'update'])
    ->middleware(['auth'])
    ->name('template.update');

Route::delete('templates/{template}', [App\Http\Controllers\TemplateController::class, 'destroy'])
    ->middleware(['auth'])
    ->name('template.destroy');

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

Route::get('documentation', \App\Livewire\Documentation::class)
    ->middleware(['auth'])
    ->name('documentation');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
