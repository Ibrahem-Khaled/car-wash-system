<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
        $carts = $user->userCart()->whereIn('status', ['pending', 'acepted'])->with('product', 'factor', 'car')->get();

        return response()->json($carts, 200);
    }

    public function aceptedOrders()
    {
        $user = Auth::guard('api')->user();
        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
        $carts = $user->userCart()->where('status', 'acepted')->with('product', 'factor', 'car')->get();
        return response()->json($carts, 200);
    }

    public function show($id)
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $cart = $user->userCart()->with('product', 'factor', 'car')->find($id);

        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        return response()->json($cart, 200);
    }

    public function store(Request $request)
    {
        $user = Auth::guard('api')->user();
        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        // البحث عن العامل الأنسب في نفس المدينة أو العامل صاحب أقل عدد من الطلبات
        $worker = User::where('role', 'factor')
            ->where(function ($query) use ($user) {
                $query->where('city', 'like', '%' . $user->city . '%')
                    ->orWhere('city', '=', null); // يدعم العمال بدون مدينة
            })
            ->withCount('factorCart')
            ->orderBy('factor_cart_count', 'asc')
            ->first();

        if (!$worker) {
            return response()->json(['message' => 'No available worker found'], 404);
        }

        // التحقق من صحة البيانات
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'car_model' => 'required|exists:cars,id',
            'car_color' => 'required|string|max:50',
            'car_number' => 'required|string|max:20',
            'car_wash' => 'required|string|max:20',
            'car_type' => 'required|string|max:20',
            'price' => 'required|numeric|min:0',
        ]);

        try {
            // إنشاء الطلب وتخصيصه للعامل
            $cart = $user->userCart()->create(array_merge($validatedData, [
                'customer_id' => $user->id,
                'factor_id' => $worker->id, 
            ]));

            return response()->json($cart, 201);
        } catch (\Exception $e) {
            // معالجة الأخطاء في حالة حدوث مشكلة أثناء إنشاء الطلب
            return response()->json(['message' => 'Failed to create cart', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $user = Auth::guard('api')->user();
        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
        $cart = $user->userCart()->find($id);
        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }
        $cart->delete();
        return response()->json(['message' => 'Cart deleted successfully'], 200);
    }
}
