<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SlideShow;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::where('parent_id', null)->get();

        return response()->json($products);
    }

    public function show($id)
    {
        $product = Product::with('children')->find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json($product);
    }

    public function search( $search)
    {
        if (!$search) {
            return response()->json([]);
        }
        $products = Product::where('name', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
            ->get();
        return response()->json($products);
    }

    public function slider()
    {
        $products = SlideShow::all();
        return response()->json($products);
    }
}
