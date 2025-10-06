<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatGPTController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// ChatGPT Content Generation
Route::post('/chatgpt-generate', [ChatGPTController::class, 'generate']);
