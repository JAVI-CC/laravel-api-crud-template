<?php

use App\Http\Controllers\RolController;
use Illuminate\Support\Facades\Route;

Route::controller(RolController::class)
    ->prefix('roles')
    ->middleware(['auth:sanctum', 'localization', 'isAdmin'])->group(function () {
        Route::get('/', 'index')->name('getRoles');
    });
