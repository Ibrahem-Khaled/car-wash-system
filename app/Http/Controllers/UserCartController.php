<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;

class UserCartController extends Controller
{
    protected $companyUser;

    // Constructor to initialize the company user
    public function __construct()
    {
        $this->companyUser = User::where('role', 'company')->first();

    }
    public function index()
    {
        $carts = Cart::where('customer_id', auth()->user()->id)
            ->get();
        //return response()->json($carts);

        return view('user-cart', [
            'companyUser' => $this->companyUser,
            'carts' => $carts
        ]);
    }

    public function store(Request $request)
    {
        //return response()->json($request->all());
        $user = auth()->user();
        $car_number = $request->car_number_letters . ' ' . $request->car_number_digits;

        $worker = User::where('role', 'factor')
            ->where('city', 'like', '%' . $user->city . '%')
            ->withCount('factorCart')
            ->orderBy('factor_cart_count', 'asc')
            ->first();

        if (!$worker) {
            $worker = User::where('role', 'factor')
                ->where(function ($query) use ($user) {
                    $query->where('city', '!=', $user->city)->orWhereNull('city');
                })
                ->withCount('factorCart')
                ->orderBy('factor_cart_count', 'asc')
                ->first();
        }

        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'car_model' => 'required|exists:cars,id',
            'car_color' => 'required|string|max:50',
            'car_wash' => 'required|date',
            'car_type' => 'required|string|max:20',
            'price' => 'required|numeric|min:0',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $cart = $user->userCart()->create(array_merge($validatedData, [
            'customer_id' => $user->id,
            'factor_id' => $worker->id,
            'car_number' => $car_number
        ]));

        return redirect()->back()->with('success', 'تم إضافة الطلب بنجاح');
    }

}
