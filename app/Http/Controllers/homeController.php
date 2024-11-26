<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Cart;
use App\Models\ContactUs;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\SubscriptionPrpduct;
use App\Models\User;
use App\Models\UserSubscription;
use App\Models\UserSubscriptionProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class homeController extends Controller
{
    protected $companyUser;

    // Constructor to initialize the company user
    public function __construct()
    {
        $this->companyUser = User::where('role', 'company')->first();
    }

    // Home page method
    public function index()
    {
        $products = Product::all();
        return view('home', [
            'products' => $products,
            'companyUser' => $this->companyUser,
        ]);
    }

    // Contact us page method
    public function contactUs()
    {
        return view('contact-us', [
            'companyUser' => $this->companyUser,
        ]);
    }

    // Handle contact us form submission
    public function contactUsPost(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'message' => 'required',
        ]);

        ContactUs::create($request->all());

        return redirect()->back()->with('success', 'تم الارسال بنجاح');
    }

    public function privacyPolicy()
    {
        return view('privacy-policy', [
            'companyUser' => $this->companyUser,
        ]);
    }

    // About us page method
    public function aboutUs()
    {
        return view('about-us', [
            'companyUser' => $this->companyUser,
        ]);
    }

    public function services()
    {
        $mainProducts = Product::where('type', 'main')->get();
        $subProducts = Product::where('type', 'sub')->get();
        $cars = Car::all();
        return view('services', [
            'companyUser' => $this->companyUser,
            'mainProducts' => $mainProducts,
            'subProducts' => $subProducts,
            'cars' => $cars
        ]);
    }

    public function getRemainingQuantity($userId, $subscriptionId, $productId)
    {
        $subscriptionProductQuantity = SubscriptionPrpduct::where('subscription_id', $subscriptionId)
            ->where('product_id', $productId)
            ->pluck('quantity')->first();

        $consumedQuantity = UserSubscriptionProduct::where('user_id', $userId)
            ->where('subscription_id', $subscriptionId)
            ->where('product_id', $productId)
            ->pluck('quantity')->first();

        $sum = $subscriptionProductQuantity - $consumedQuantity;

        return $sum < 0 ? 0 : $sum;
    }

    public function subscribtion()
    {
        $subscriptions = Subscription::with('products')->get();
        return view('subscribtion', [
            'companyUser' => $this->companyUser,
            'subscriptions' => $subscriptions,
        ]);
    }

    public function addSubscribtionToUser(Request $request)
    {
        $request->validate([
            'subscription_id' => 'required|exists:subscriptions,id',

        ]);

        $user = Auth::user();
        $user->subscriptions()->attach($request->subscription_id);
        return redirect()->back()->with('success', 'تم اضافة الاشتراك بنجاح');
    }

    public function requestService(Request $request)
    {
        $validated = $request->validate([
            'subscription_id' => 'required|exists:subscriptions,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $worker = User::where('role', 'supervisor')

            ->first();

        // تحقق من الاشتراك وحالته
        $subscription = UserSubscription::where('user_id', auth()->id())
            ->where('subscription_id', $validated['subscription_id'])
            ->where('status', 'active')
            ->first();

        if (!$subscription) {
            return redirect()->back()->with('error', 'الاشتراك غير نشط أو غير موجود.');
        }

        // تحقق من الكمية المتبقية للمنتج
        $remainingQuantity = app()->call(
            'App\Http\Controllers\homeController@getRemainingQuantity',
            [
                'userId' => auth()->id(),
                'subscriptionId' => $validated['subscription_id'],
                'productId' => $validated['product_id'],
            ]
        );

        if ($validated['quantity'] > $remainingQuantity) {
            return redirect()->back()->with('error', 'الكمية المطلوبة غير متوفرة.');
        }

        UserSubscriptionProduct::create([
            'user_id' => auth()->id(),
            'subscription_id' => $validated['subscription_id'],
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity'],
        ]);

        // إضافة الطلب إلى سلة المشتريات
        for ($i = 0; $i < $validated['quantity']; $i++) {
            Cart::create([
                'customer_id' => auth()->id(),
                'factor_id' => $worker->id,
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'car_model' => $request->input('car_model'),
                'car_color' => $request->input('car_color'),
                'status' => 'pending',
                'paid' => 'paid',
            ]);
        }

        return redirect()->back()->with('success', 'تم تقديم الطلب بنجاح.');
    }

    public function userOrders()
    {
        $user = Auth::user(); // الحصول على المستخدم الحالي

        if ($user->role === 'factor' || $user->role === 'supervisor') {
            $orders = $user->factorCart()
                ->whereIn('paid', ['paid', 'cash_on_delivery'])
                ->with('product', 'car', 'customer')->get();
            $workers = User::where('role', 'factor')->get();
            $allOrdersToSupervisor = Cart::get();

            return view('factor.orders', [
                'companyUser' => $this->companyUser,
                'orders' => $orders,
                'workers' => $workers,
                'allOrdersToSupervisor' => $allOrdersToSupervisor
            ]);
        } else {
            $orders = $user->userCart()
                ->whereIn('paid', ['paid', 'cash_on_delivery'])
                ->with('product', 'car', 'customer')
                ->get(); // التأكد من جلب المنتجات مع الطلبات

            return view('user-orders', [
                'companyUser' => $this->companyUser,
                'orders' => $orders
            ]);
        }
    }

    public function updateStatus(Request $request, Cart $cart)
    {
        $request->validate([
            'status' => 'required|in:acepted,declined,pending,completed,unpaid',
            'worker_id' => 'nullable|exists:users,id',
            'decline_reason' => 'required_if:status,declined|string|nullable',
        ]);
        $worker = User::where('role', 'supervisor')->first();

        $cart->status = $request->input('status');
        $cart->factor_id = $request->input('worker_id') === null ? $cart->factor_id : $request->input('worker_id');

        if ($request->input('status') == 'declined') {
            $cart->decline_reason = $request->input('decline_reason');
            $cart->factor_id = $worker->id;
        }

        $cart->save();

        return back()->with('success', 'تم تحديث حالة الطلب وتحديد العامل بنجاح.');
    }

    public function userSubscriptions()
    {
        $user = User::find(Auth::id());
        $subscriptions = $user->subscriptions()->with('products')->get();
        $cars = Car::all();
        return view('user-subscriptions', [
            'companyUser' => $this->companyUser,
            'subscriptions' => $subscriptions,
            'cars' => $cars
        ]);
    }
}
