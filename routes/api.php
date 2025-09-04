<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MediaController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Admin API routes for media picker
Route::prefix('admin')->middleware(['web', 'auth'])->group(function () {
    Route::get('/api/media', [MediaController::class, 'index']);
    Route::get('/api/media/{media}', [MediaController::class, 'show']);
});
