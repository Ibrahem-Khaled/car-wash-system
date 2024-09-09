<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // إحصائيات العمليات الناجحة
        $successfulOperations = Cart::where('status', 'active')->count();

        // عدد العمال
        $workerCount = User::where('role', 'factor')->count();

        // إجمالي الأرباح
        $totalEarnings = Cart::where('status', 'active')->sum('price');

        // إحصائيات إضافية
        $inactiveOperations = Cart::where('status', 'inactive')->count();
        $totalUsers = User::count();
        $totalProducts = DB::table('products')->count();

        return view(
            'dashboard.index',
            compact(
                'successfulOperations',
                'workerCount',
                'totalEarnings',
                'inactiveOperations',
                'totalUsers',
                'totalProducts'
            )
        );
    }

    public function homePage()
    {
        $products = Product::all();
        $workers = User::where('role', 'factor')->get();
        return view('home', compact('products', 'workers'));
    }
}
