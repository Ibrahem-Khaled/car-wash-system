<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CarsController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\FactorOrderController;
use App\Http\Controllers\Api\homeController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/user', [AuthController::class, 'user'])->middleware('jwt.auth');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('jwt.auth');
Route::put('/update-user', [AuthController::class, 'update'])->middleware('jwt.auth');
Route::delete('/delete-account', [AuthController::class, 'deleteAccount'])->middleware('jwt.auth');
Route::post('/change-password', [AuthController::class, 'changePassword'])->middleware('jwt.auth');
Route::post('/expo-push-token', [AuthController::class, 'expoPushToken'])->middleware('jwt.auth');


Route::group([], function () {
    // this route for products
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::get('/search/{search}', [ProductController::class, 'search']);

    // this route for carts
    Route::get('/carts', [CartController::class, 'index']);
    Route::get('/aceptedOrders', [CartController::class, 'aceptedOrders']);
    Route::get('/carts/{id}', [CartController::class, 'show']);
    Route::post('/store/carts', [CartController::class, 'store']);
    Route::delete('/delete/cart/{id}', [CartController::class, 'destroy']);

    //this route for car
    Route::get('/cars', [CarsController::class, 'index']);

    //this route for slider
    Route::get('/slider', [ProductController::class, 'slider']);

    //this main routes
    Route::get('notification', [homeController::class, 'notification']);

    //this route for factor 
    Route::get('/factor/orders', [FactorOrderController::class, 'getFactorOrder']);

});
