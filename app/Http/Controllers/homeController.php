<?php

namespace App\Http\Controllers;

use App\Models\Car;
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
            'subscriptions' => $subscriptions
        ]);
    }

    public function userOrders()
    {
        $user = User::find(Auth::id());
        $orders = $user->userCart()->with('product', 'factor', 'car')->get();
        return view('user-orders', [
            'companyUser' => $this->companyUser,
            'orders' => $orders
        ]);
    }

    public function userSubscriptions()
    {
        $user = User::find(Auth::id());
        $subscriptions = $user->subscriptions()->with('products')->get();

        return view('user-subscriptions', [
            'companyUser' => $this->companyUser,
            'subscriptions' => $subscriptions
        ]);
    }
}
