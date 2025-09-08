<?php

use Illuminate\Support\Facades\Route;

// CORS test endpoints
Route::get('/cors-test', function () {
    return response()->json([
        'success' => true,
        'message' => 'CORS is working!',
        'timestamp' => now(),
        'origin' => request()->header('Origin'),
        'user_agent' => request()->header('User-Agent'),
        'method' => request()->method(),
    ]);
});

Route::post('/cors-test', function () {
    return response()->json([
        'success' => true,
        'message' => 'CORS POST is working!',
        'timestamp' => now(),
        'origin' => request()->header('Origin'),
        'user_agent' => request()->header('User-Agent'),
        'method' => request()->method(),
        'data' => request()->all(),
    ]);
});

Route::options('/cors-test', function () {
    return response('', 200);
});

// WebSocket endpoints for display connections (excluded from CSRF protection)
Route::prefix('websocket')->group(function () {
    Route::post('/display/connect', [App\Http\Controllers\WebSocketController::class, 'connect']);
    Route::post('/display/disconnect', [App\Http\Controllers\WebSocketController::class, 'disconnect']);
    Route::post('/display/heartbeat', [App\Http\Controllers\WebSocketController::class, 'heartbeat']);
    Route::post('/display/check-template', [App\Http\Controllers\WebSocketController::class, 'checkTemplate']);
    Route::get('/displays', [App\Http\Controllers\WebSocketController::class, 'getDisplays']);
});

// Display template API endpoints (public, no authentication required)
Route::prefix('display')->group(function () {
    // Check if display has an active template
    Route::get('/template/check', [App\Http\Controllers\Api\DisplayTemplateController::class, 'checkTemplate']);
    Route::post('/template/check', [App\Http\Controllers\Api\DisplayTemplateController::class, 'checkTemplate']);
    
    // Get template content (HTML, CSS, JS)
    Route::get('/template/content', [App\Http\Controllers\Api\DisplayTemplateController::class, 'getTemplateContent']);
    Route::post('/template/content', [App\Http\Controllers\Api\DisplayTemplateController::class, 'getTemplateContent']);
    
    // Report display status and capabilities
    Route::post('/status', [App\Http\Controllers\Api\DisplayTemplateController::class, 'reportStatus']);
});

// WebSocket message handling (public, no authentication required)
Route::post('/websocket/message', [App\Http\Controllers\WebSocketMessageController::class, 'handleMessage']);
