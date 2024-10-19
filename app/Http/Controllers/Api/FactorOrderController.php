<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FactorOrderController extends Controller
{
    public function getFactorOrder(Request $request)
    {
        $user = Auth::guard('api')->user();

        if (!$user->role == 'factor') {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $orders = $user->factorCart()->with('product', 'factor', 'car')->get();
        return response()->json($orders, 200);

    }
}
