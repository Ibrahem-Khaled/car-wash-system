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
        $user = auth()->user();
        $car_number = $request->car_number_letters . ' ' . $request->car_number_digits;

        // البحث عن العامل الأنسب في نفس المدينة أو العامل صاحب أقل عدد من الطلبات
        $worker = User::where('role', 'factor')
            ->where('city', 'like', '%' . $user->city . '%') // محاولة العثور على عامل من نفس المدينة
            ->withCount('factorCart')
            ->orderBy('factor_cart_count', 'asc')
            ->first();

        if (!$worker) {
            // إذا لم يتم العثور على عامل من نفس المدينة، يتم البحث عن أي عامل آخر
            $worker = User::where('role', 'factor')
                ->where('city', 'not like', '%' . $user->city . '%') // أي مدينة أخرى غير المدينة الحالية
                ->orWhereNull('city') // يشمل العمال بدون مدينة
                ->withCount('factorCart')
                ->orderBy('factor_cart_count', 'asc')
                ->first();
        }

        // التحقق من صحة البيانات
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'car_model' => 'required|exists:cars,id',
            'car_color' => 'required|string|max:50',
            'car_wash' => 'required|string|max:20',
            'car_type' => 'required|string|max:20',
            'price' => 'required|numeric|min:0',
        ]);

        try {
            // إنشاء الطلب وتخصيصه للعامل
            $cart = $user->userCart()->create(array_merge($validatedData, [
                'customer_id' => $user->id,
                'factor_id' => $worker->id,
                'car_number' => $car_number
            ]));

            return redirect()->back()->with('success', 'تم اضافة الطلب بنجاح');
        } catch (\Exception $e) {
            // معالجة الأخطاء في حالة حدوث مشكلة أثناء إنشاء الطلب
            return response()->json(['message' => 'Failed to create cart', 'error' => $e->getMessage()], 500);
        }
    }

}
