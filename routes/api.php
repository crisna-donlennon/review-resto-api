<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\RestoController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthenticationController::class, 'login'])->name('auth.login');
Route::post('/auth/register', [AuthenticationController::class, 'register'])->name('auth.register');


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/profile', [AuthenticationController::class, 'profile'])->name('auth.profile');
    Route::get('/auth/logout', [AuthenticationController::class, 'logout'])->name('auth.logout');
    
    Route::apiResource('restos', RestoController::class);
});

Route::apiResource('reviews', ReviewController::class);