<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

// Auth
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/is_login', [AuthController::class, 'is_login'])->middleware('auth:api')->name('is_login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
    Route::post('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('me');
});

// Users
Route::group([
    'middleware' => 'api',
    'prefix' => 'users'
], function ($router) {
    Route::get('/', [UserController::class, 'index'])->middleware('auth:api')->name('index');
    Route::post('/{id}/activate', [UserController::class, 'activate'])->middleware('auth:api')->name('activate');
    Route::post('/{id}/deactivate', [UserController::class, 'deactivate'])->middleware('auth:api')->name('deactivate');
    Route::delete('/{id}', [UserController::class, 'destroy'])->middleware('auth:api')->name('destroy');
});
