<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::with('products')->get();
        $products = Product::all();
        return view('dashboard.subscriptions.index', compact('subscriptions', 'products'));
    }

    public function store(Request $request)
    {
        $subscription = Subscription::create($request->only(['name', 'description', 'price', 'status', 'image', 'duration']));

        // ربط المنتجات مع الكمية
        $products = collect($request->input('products'))->mapWithKeys(function ($productId) use ($request) {
            return [$productId => ['quantity' => $request->input('quantities')[$productId]]];
        });

        $subscription->products()->attach($products);

        return redirect()->route('subscriptions.index')->with('success', 'تم إنشاء الاشتراك بنجاح');
    }

    public function update(Request $request, $id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->update($request->only(['name', 'description', 'price', 'status', 'image', 'duration']));

        $products = collect($request->input('products'))->mapWithKeys(function ($productId) use ($request) {
            return [$productId => ['quantity' => $request->input('quantities')[$productId]]];
        });

        $subscription->products()->sync($products);

        return redirect()->route('subscriptions.index')->with('success', 'تم تعديل الاشتراك بنجاح');
    }

    public function destroy($id)
    {
        Subscription::destroy($id);
        return redirect()->route('subscriptions.index')->with('success', 'تم حذف الاشتراك بنجاح');
    }

    public function subscriptionsRemoveProduct($subscriptionId, $productId)
    {
        $subscription = Subscription::findOrFail($subscriptionId);
        $subscription->products()->detach($productId);
        return redirect()->route('subscriptions.index')->with('success', 'تم حذف المنتج من الاشتراك بنجاح');
    }
}
