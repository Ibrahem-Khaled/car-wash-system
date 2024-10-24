<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::paginate(10);
        $users = User::where('role', 'customer')->get();
        $factors = User::where('role', 'factor')->get();
        $products = Product::all();
        $cars = Car::all();
        return view('dashboard.carts.carts', compact('carts', 'users', 'factors', 'products', 'cars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'factor_id' => 'nullable|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'price' => 'nullable|numeric',
        ]);

        Cart::create($request->all());

        return redirect()->back()->with('success', 'Cart created successfully.');
    }

    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'factor_id' => 'nullable|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'price' => 'nullable|numeric',
        ]);

        $cart->update($request->all());

        return redirect()->back()->with('success', 'Cart updated successfully.');
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();
        return redirect()->back()->with('success', 'Cart deleted successfully.');
    }

    public function acceptOrder(Cart $cart)
    {
        $cart->update(['status' => 'acepted']);
        return redirect()->back()->with('success', 'Order accepted.');
    }

    public function declineOrder(Cart $cart)
    {
        $cart->update(['status' => 'declined']);
        return redirect()->back()->with('success', 'Order declined.');
    }
}
