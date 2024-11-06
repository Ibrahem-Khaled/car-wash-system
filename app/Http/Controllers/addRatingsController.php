<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\UserRating;
use Illuminate\Http\Request;

class addRatingsController extends Controller
{
    public function index($cart)
    {
        $order = Cart::find($cart);
        return view('factors.factor_ratings', compact('order'));
    }

    public function store(Request $request)
    {
        $order = Cart::find($request->order_id);

        UserRating::create([
            'user_id' => auth()->user()->id,
            'factor_id' => $order->factor_id,
            'cart_id' => $order->id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);
        return redirect()->back()->with('success', 'تم التقييم بنجاح');
    }
}
