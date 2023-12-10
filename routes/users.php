<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)
    ->prefix('auth')
    ->group(function () {
        Route::middleware(['localization'])->post('login', 'login')->name('login');
        Route::middleware(['auth:sanctum', 'localization'])->get('check', 'check')->name('check');
        Route::middleware(['auth:sanctum', 'verified', 'localization'])->get('logout', 'logout')->name('logout');
        Route::middleware(['auth:sanctum', 'verified', 'localization'])->post('change/password', 'changePassword')->name('changePassowrd');
        Route::middleware(['localization'])->post('recovery/password', 'recoveryPassword')->name('recoveryPassowrd');
    });

Route::controller(UserController::class)
    ->prefix('user')
    ->middleware(['auth:sanctum', 'localization', 'isAdmin', 'verified'])->group(function () {
        Route::get('/', 'index')->name('getUsers');
        Route::get('/{user:id}', 'show')->name('showUser');
        Route::post('/', 'store')->name('addUser');
        Route::put('/{user:id}', 'update')->name('updateUser');
        Route::delete('/{user:id}', 'destroy')->name('deleteUser')->can('delete', 'user');
        Route::get('/export/pdf', 'exportUsersPDF')->name('exportUsersPDF');
        Route::get('/export/excel', 'exportUsersExcel')->name('exportUsersExcel');
    });

Route::controller(EmailVerificationController::class)
    ->prefix('/user/verification/email')
    ->middleware(['auth:sanctum', 'localization'])
    ->group(function () {
        Route::post('notification', 'sendVerificationEmail')->name('UserSendVerificationEmail');
        Route::get('{id}/{hash}', 'verify')->name('UserVerificationEmail');
    });
