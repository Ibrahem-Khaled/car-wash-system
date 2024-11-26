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
        // التحقق من البيانات المدخلة
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'description' => 'nullable|string',
        //     'price' => 'required|numeric',
        //     'status' => 'required|boolean',
        //     'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // التحقق من نوع وحجم الصورة
        //     'duration' => 'required|integer',
        //     'products' => 'nullable|array',
        //     'quantities' => 'nullable|array',
        // ]);

        // رفع الصورة إذا تم إدخالها
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('subscriptions', 'public'); // تخزين الصورة في مجلد 'subscriptions' داخل التخزين العام
        }

        // إنشاء الاشتراك
        $subscription = Subscription::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            // 'status' => $request->input('status'),
            'image' => $imagePath, // حفظ مسار الصورة
            'duration' => $request->input('duration'),
        ]);

        // ربط المنتجات مع الكمية
        if ($request->has('products') && $request->has('quantities')) {
            $products = collect($request->input('products'))->mapWithKeys(function ($productId) use ($request) {
                $quantity = $request->input('quantities')[$productId] ?? 0; // التحقق من وجود الكمية
                if ($quantity > 0) {
                    return [$productId => ['quantity' => $quantity]];
                }
                return []; // تجاهل المنتجات ذات الكمية صفر
            })->filter(); // إزالة العناصر الفارغة
        }

        if (isset($products) && $products->isNotEmpty()) {
            $subscription->products()->attach($products);
        }

        return redirect()->route('subscriptions.index')->with('success', 'تم إنشاء الاشتراك بنجاح');
    }


    public function update(Request $request, $id)
    {
        $subscription = Subscription::findOrFail($id);

        // التحقق من البيانات المدخلة
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'description' => 'nullable|string',
        //     'price' => 'required|numeric',
        //     'status' => 'required|boolean',
        //     'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // التحقق من نوع وحجم الصورة
        //     'duration' => 'required|integer',
        //     'products' => 'nullable|array',
        //     'quantities' => 'nullable|array',
        // ]);

        // رفع الصورة الجديدة إذا وُجدت
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($subscription->image && \Storage::exists('public/' . $subscription->image)) {
                \Storage::delete('public/' . $subscription->image);
            }

            // تخزين الصورة الجديدة
            $imagePath = $request->file('image')->store('subscriptions', 'public');
            $subscription->image = $imagePath; // تحديث مسار الصورة
        }

        // تحديث بقية البيانات
        $subscription->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            // 'status' => $request->input('status'),
            'duration' => $request->input('duration'),
        ]);

        // تحديث المنتجات والكميات
        if ($request->has('products') && $request->has('quantities')) {
            $products = collect($request->input('products'))->mapWithKeys(function ($productId) use ($request) {
                $quantity = $request->input('quantities')[$productId] ?? 0;
                if ($quantity > 0) {
                    return [$productId => ['quantity' => $quantity]];
                }
                return [];
            })->filter();
        }

        if (isset($products) && $products->isNotEmpty()) {
            $subscription->products()->sync($products); // تحديث الربط مع المنتجات
        }

        return redirect()->route('subscriptions.index')->with('success', 'تم تعديل الاشتراك بنجاح');
    }


    public function destroy($id)
    {
        $subscription = Subscription::findOrFail($id);
        \Storage::delete('public/' . $subscription->image);

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
