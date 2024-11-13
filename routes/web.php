<?php

use App\Http\Controllers\addRatingsController;
use App\Http\Controllers\dashboard\CarController;
use App\Http\Controllers\dashboard\CartController;
use App\Http\Controllers\dashboard\ContactUsController;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\dashboard\NotificationModelController;
use App\Http\Controllers\dashboard\ProductController;
use App\Http\Controllers\dashboard\SlideShowController;
use App\Http\Controllers\dashboard\SubscriptionController;
use App\Http\Controllers\dashboard\UserController;
use App\Http\Controllers\dashboard\UserRatingController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\UserCartController;
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

require __DIR__ . '/auth.php';

Route::group([], function () {
    //this home screen
    Route::get('/', [DashboardController::class, 'homePage'])->name('home');

    //this contact us routes
    Route::get('/contact-us', [homeController::class, 'contactUs'])->name('contact-us');
    Route::post('/contact-us', [homeController::class, 'contactUsPost'])->name('contact-us.post');

    Route::get('/about-us', [homeController::class, 'aboutUs'])->name('about-us');

    Route::get('/services', [homeController::class, 'services'])->name('services');

    Route::get('/subscribtion', [homeController::class, 'subscribtion'])->name('subscribtion');

    Route::get('/user/orders', [homeController::class, 'userOrders'])->name('user.orders')->middleware('checkOtpVerification');
    Route::put('orders/{cart}/update-status', [homeController::class, 'updateStatus'])->name('updateOrderStatus')->middleware('checkOtpVerification');


    Route::get('user/subscriptions', [homeController::class, 'userSubscriptions'])->name('user.subscriptions')->middleware('checkOtpVerification');


    //this cart routes
    Route::get('/carts', [UserCartController::class, 'index'])->name('user.carts')->middleware(['auth', 'checkOtpVerification']);
    Route::post('/carts', [UserCartController::class, 'store'])->name('user.carts.store')->middleware(['auth', 'checkOtpVerification']);
    Route::post('/carts/update-payment', [UserCartController::class, 'updatePayment'])->name('user.carts.updatePayment')->middleware(['auth', 'checkOtpVerification']);
    Route::post('/carts/add-reference-number', [UserCartController::class, 'addReferenceNumber'])->name('user.carts.addReferenceNumber')->middleware(['auth', 'checkOtpVerification']);
    Route::get('user/delete/cart/{cart}', [UserCartController::class, 'destroy'])->name('user.carts.destroy')->middleware(['auth', 'checkOtpVerification']);

    //this add review routes
    Route::get('/add-review/{cart}', [addRatingsController::class, 'index'])->name('add.review')->middleware(['auth', 'checkOtpVerification']);
    Route::post('/add-review', [addRatingsController::class, 'store'])->name('worker.rate')->middleware(['auth', 'checkOtpVerification']);

});


Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'checkAdmin', 'checkOtpVerification']], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('home.dashboard')->middleware('auth');

    // user routes
    Route::resource('users', UserController::class);

    // product routes
    Route::resource('products', ProductController::class);

    // car routes
    Route::resource('cars', CarController::class);

    // cart routes
    Route::resource('carts', CartController::class);
    Route::post('carts/{cart}/accept', [CartController::class, 'updateStatus'])->name('dashboard.carts.updateStatus');

    // user rating routes
    Route::resource('user_ratings', UserRatingController::class);
    Route::post('user_ratings/{rating}/accept', [UserRatingController::class, 'acceptRating'])->name('dashboard.user_ratings.acceptRating');

    // slide show routes
    Route::resource('slide_shows', SlideShowController::class);

    //notification routes
    Route::resource('notifications', NotificationModelController::class);

    //this contact us routes
    Route::resource('contact-us', ContactUsController::class);

    //this user route supscription
    Route::resource('subscriptions', SubscriptionController::class);
    Route::delete('subscriptions/{subscriptionId}/{productId}/removeProduct', [SubscriptionController::class, 'subscriptionsRemoveProduct'])->name('subscriptions.removeProduct');
});
