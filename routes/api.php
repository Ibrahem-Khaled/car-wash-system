<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CarsController;
use App\Http\Controllers\Api\CartController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/user', [AuthController::class, 'user'])->middleware('jwt.auth');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('jwt.auth');


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

});
