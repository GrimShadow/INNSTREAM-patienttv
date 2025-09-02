<?php

use Illuminate\Support\Facades\Route;

// WebSocket endpoints for display connections (excluded from CSRF protection)
Route::prefix('websocket')->group(function () {
    Route::post('/display/connect', [App\Http\Controllers\WebSocketController::class, 'connect']);
    Route::post('/display/disconnect', [App\Http\Controllers\WebSocketController::class, 'disconnect']);
    Route::post('/display/heartbeat', [App\Http\Controllers\WebSocketController::class, 'heartbeat']);
    Route::get('/displays', [App\Http\Controllers\WebSocketController::class, 'getDisplays']);
});
