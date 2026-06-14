<?php

use App\Http\Controllers\DeployController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'Hello, World!';
});

Route::get('/deploy/database', [DeployController::class, 'database']);
