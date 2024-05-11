<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\SettingController;

// Test
Route::get('/hello', function () {
    return 'Hello, World!';
});

// Auth
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::post('/is_login', [AuthController::class, 'is_login'])->middleware('auth:api')->name('is_login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('me');
});

// Users
Route::group([
    'middleware' => 'api',
    'prefix' => 'users'
], function ($router) {
    Route::get('/', [UserController::class, 'index'])->middleware('auth:api')->name('users.index');
    Route::post('/', [UserController::class, 'store'])->middleware('auth:api')->name('users.store');
    Route::put('/{id}', [UserController::class, 'update'])->middleware('auth:api')->name('users.update');
    Route::post('/{id}/activate', [UserController::class, 'activate'])->middleware('auth:api')->name('users.activate');
    Route::post('/{id}/deactivate', [UserController::class, 'deactivate'])->middleware('auth:api')->name('users.deactivate');
    Route::delete('/{id}', [UserController::class, 'destroy'])->middleware('auth:api')->name('users.destroy');
});

// Jobs
Route::group([
    'middleware' => 'api',
    'prefix' => 'jobs'
], function ($router) {
    Route::get('/', [JobController::class, 'index'])->middleware('auth:api')->name('jobs.index');
    Route::post('/', [JobController::class, 'store'])->middleware('auth:api')->name('jobs.store');
    Route::put('/{id}', [JobController::class, 'update'])->middleware('auth:api')->name('jobs.update');
    Route::post('/{id}/activate', [JobController::class, 'activate'])->middleware('auth:api')->name('jobs.activate');
    Route::post('/{id}/deactivate', [JobController::class, 'deactivate'])->middleware('auth:api')->name('jobs.deactivate');
    Route::delete('/{id}', [JobController::class, 'destroy'])->middleware('auth:api')->name('jobs.destroy');
});

// Payroll
Route::group([
    'middleware' => 'api',
    'prefix' => 'payrolls'
], function ($router) {
    Route::get('/', [PayrollController::class, 'index'])->middleware('auth:api')->name('payrolls.index');
    Route::post('/', [PayrollController::class, 'store'])->middleware('auth:api')->name('payrolls.store');
});

// Timesheets
Route::group([
    'middleware' => 'api',
    'prefix' => 'timesheets'
], function ($router) {
    Route::get('/', [TimesheetController::class, 'index'])->middleware('auth:api')->name('timesheets.index');
    Route::post('/', [TimesheetController::class, 'store'])->middleware('auth:api')->name('timesheets.store');
    Route::put('/{id}', [TimesheetController::class, 'update'])->middleware('auth:api')->name('timesheets.update');
    Route::post('/{id}/approve', [TimesheetController::class, 'approve'])->middleware('auth:api')->name('timesheets.approve');
    Route::post('/{id}/unapprove', [TimesheetController::class, 'unapprove'])->middleware('auth:api')->name('timesheets.unapprove');
    Route::delete('/{id}', [TimesheetController::class, 'destroy'])->middleware('auth:api')->name('timesheets.destroy');
});

// Settings
Route::group([
    'middleware' => 'api',
    'prefix' => 'settings'
], function ($router) {
    Route::get('/', [SettingController::class, 'index'])->middleware('auth:api')->name('settings.index');
    Route::post('/', [SettingController::class, 'update'])->middleware('auth:api')->name('settings.update');
});
