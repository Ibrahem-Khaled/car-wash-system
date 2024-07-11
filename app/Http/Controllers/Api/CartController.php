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
        $carts = $user->userCart()->with('product', 'factor', 'car')->get();

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

        $worker = User::where('role', 'factor')
            ->where('city', 'like', '%' . $user->city . '%')
            ->withCount('factorCart')
            ->orderBy('factor_cart_count', 'asc')
            ->first();

        if (!$worker) {
            return response()->json(['message' => 'No workers available in your city'], 404);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'car_model' => 'required|exists:cars,id',
            'car_color' => 'required|string',
            'car_number' => 'required|string',
            'car_wash' => 'required|string',
            'car_type' => 'required|string',
            'price' => 'required|numeric',
        ]);

        $cart = $user->userCart()->create([
            'product_id' => $request->product_id,
            'car_model' => $request->car_model,
            'car_color' => $request->car_color,
            'car_number' => $request->car_number,
            'car_wash' => $request->car_wash,
            'car_type' => $request->car_type,
            'price' => $request->price,
            'customer_id' => $user->id,
            'factor_id' => $worker->id,
        ]);

        return response()->json($cart, 201);
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
