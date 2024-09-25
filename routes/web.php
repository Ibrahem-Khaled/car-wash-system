<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboard\CarController;
use App\Http\Controllers\dashboard\CartController;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\dashboard\NotificationModelController;
use App\Http\Controllers\dashboard\ProductController;
use App\Http\Controllers\dashboard\SlideShowController;
use App\Http\Controllers\dashboard\UserController;
use App\Http\Controllers\dashboard\UserRatingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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


Route::get('/', [DashboardController::class, 'homePage'])->name('landing.page');


Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'checkAdmin']], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('home')->middleware('auth');

    // user routes
    Route::resource('users', UserController::class);

    // product routes
    Route::resource('products', ProductController::class);

    // car routes
    Route::resource('cars', CarController::class);

    // cart routes
    Route::resource('carts', CartController::class);
    Route::post('carts/{cart}/accept', [CartController::class, 'acceptOrder'])->name('dashboard.carts.acceptOrder');
    Route::post('carts/{cart}/decline', [CartController::class, 'declineOrder'])->name('dashboard.carts.declineOrder');

    // user rating routes
    Route::resource('user_ratings', UserRatingController::class);
    Route::post('user_ratings/{rating}/accept', [UserRatingController::class, 'acceptRating'])->name('dashboard.user_ratings.acceptRating');

    // slide show routes
    Route::resource('slide_shows', SlideShowController::class);

    //notification routes
    Route::resource('notifications', NotificationModelController::class);
});
