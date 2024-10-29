<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;




Route::group(['prefix' => 'auth'], function () {
    // this auth routes
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'customLogin'])->name('customLogin');

    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('register', [AuthController::class, 'customRegister'])->name('customRegister');

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('profile', [AuthController::class, 'profile'])->name('profile')->middleware('auth');
    Route::post('/profile', [AuthController::class, 'update'])->name('profile.update');

    Route::get('forget-password', [AuthController::class, 'forgetPassword'])->name('forgetPassword');
    Route::post('resetPassword', [AuthController::class, 'resetPassword'])->name('resetPassword');
    
    Route::delete('account/delete', [AuthController::class, 'destroy'])->name('account.delete');
});