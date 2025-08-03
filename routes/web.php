<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Controllers - Frontend
use App\Http\Controllers\homeController;
use App\Http\Controllers\UserCartController;
use App\Http\Controllers\addRatingsController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CustomerManagementController;
use App\Http\Controllers\LoyaltyController;

// Controllers - Dashboard
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\dashboard\UserController;
use App\Http\Controllers\dashboard\ProductController;
use App\Http\Controllers\dashboard\CarController;
use App\Http\Controllers\dashboard\CartController;
use App\Http\Controllers\dashboard\UserRatingController;
use App\Http\Controllers\dashboard\SlideShowController;
use App\Http\Controllers\dashboard\NotificationModelController;
use App\Http\Controllers\dashboard\ContactUsController;
use App\Http\Controllers\dashboard\SubscriptionController;
use App\Http\Controllers\dashboard\ChatController as DashboardChatController;
use App\Http\Controllers\dashboard\SettingController;
use App\Http\Controllers\WalletPassController;

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

// --- مسارات المصادقة ---
require __DIR__ . '/web/auth.php';

// --- مسارات عامة للواجهة الأمامية ---
Route::post('/change-language', function (Request $request) {
    session(['language' => $request->language]);
    return redirect()->back();
})->name('change-language');

Route::group([], function () {

    // -- الصفحات الرئيسية والمعلوماتية --
    Route::get('/', [homeController::class, 'index'])->name('home');
    Route::get('/contact-us', [homeController::class, 'contactUs'])->name('contact-us');
    Route::post('/contact-us', [homeController::class, 'contactUsPost'])->name('contact-us.post');
    Route::get('/about-us', [homeController::class, 'aboutUs'])->name('about-us');
    Route::get('/privacy-policy', [homeController::class, 'privacyPolicy'])->name('privacy-policy');
    Route::get('/services', [homeController::class, 'services'])->name('services');
    Route::get('/subscribtion', [homeController::class, 'subscribtion'])->name('subscribtion');

    // -- مسارات المستخدم المسجل دخوله --
    Route::middleware(['auth', 'checkOtpVerification'])->group(function () {
        // الطلبات والاشتراكات
        Route::get('/user/orders', [homeController::class, 'userOrders'])->name('user.orders');
        Route::put('orders/{cart}/update-status', [homeController::class, 'updateStatus'])->name('updateOrderStatus');
        Route::get('user/subscriptions', [homeController::class, 'userSubscriptions'])->name('user.subscriptions');

        // سلة المشتريات
        Route::get('/carts', [UserCartController::class, 'index'])->name('user.carts');
        Route::post('/carts', [UserCartController::class, 'store'])->name('user.carts.store');
        Route::post('/carts/update-payment', [UserCartController::class, 'updatePayment'])->name('user.carts.updatePayment');
        Route::post('/carts/add-reference-number', [UserCartController::class, 'addReferenceNumber'])->name('user.carts.addReferenceNumber');
        Route::get('user/delete/cart/{cart}', [UserCartController::class, 'destroy'])->name('user.carts.destroy');

        // إضافة الاشتراكات وطلب الخدمات
        Route::post('add-subscription', [homeController::class, 'addSubscribtionToUser'])->name('add.subscription');
        Route::post('request-service', [homeController::class, 'requestService'])->name('user.requestService');

        // التقييمات والمراجعات
        Route::get('/add-review/{cart}', [addRatingsController::class, 'index'])->name('add.review');
        Route::post('/add-review', [addRatingsController::class, 'store'])->name('worker.rate');
    });

    // -- مسارات المحادثة --
    Route::middleware('auth')->group(function () {
        Route::get('/chat/messages', [ChatController::class, 'fetchMessages'])->name('chat.messages');
        Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    });

    // -- مسارات نظام الولاء --
    Route::get('/customers/create', [CustomerManagementController::class, 'create'])->name('customers.create');
    Route::post('/customers', [CustomerManagementController::class, 'store'])->name('customers.store');
    Route::get('/customers/{user}', [CustomerManagementController::class, 'show'])->name('customers.show');
    Route::get('/scan/{identifier}', [LoyaltyController::class, 'scan'])->name('loyalty.scan')->middleware('auth');
    Route::post('/customers/{user}/use-gift', [LoyaltyController::class, 'useGift'])->name('loyalty.useGift');

    Route::get('/user/{user}/apple-pass', [WalletPassController::class, 'generateLoyaltyPass'])
        ->name('wallet.apple.generate');
});


// --- مسارات لوحة التحكم (Dashboard) ---
Route::group([
    'prefix' => 'dashboard',
    // 'middleware' => ['auth', 'checkAdmin', 'checkOtpVerification']
], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('home.dashboard');

    // إدارة الموارد (Users, Products, etc.)
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::resource('cars', CarController::class);
    Route::resource('carts', CartController::class);
    Route::resource('user_ratings', UserRatingController::class);
    Route::resource('slide_shows', SlideShowController::class);
    Route::resource('notifications', NotificationModelController::class);
    Route::resource('contact-us', ContactUsController::class);
    Route::resource('subscriptions', SubscriptionController::class);

    // مسارات إضافية مخصصة
    Route::post('carts/{cart}/accept', [CartController::class, 'updateStatus'])->name('dashboard.carts.updateStatus');
    Route::post('user_ratings/{rating}/accept', [UserRatingController::class, 'acceptRating'])->name('dashboard.user_ratings.acceptRating');
    Route::delete('subscriptions/{subscriptionId}/{productId}/removeProduct', [SubscriptionController::class, 'subscriptionsRemoveProduct'])->name('subscriptions.removeProduct');

    // مسارات المحادثة المباشرة في لوحة التحكم
    Route::get('/live/chat', [DashboardChatController::class, 'index'])->name('live.chat');
    Route::get('/users/{userId}/messages', [DashboardChatController::class, 'getUserMessages']);
    Route::post('/messages/reply', [DashboardChatController::class, 'replyToMessage']);

    // Route to display the settings page
    Route::get('settings', [SettingController::class, 'edit'])->name('dashboard.settings.edit');
    Route::put('settings', [SettingController::class, 'update'])->name('dashboard.settings.update');
});
