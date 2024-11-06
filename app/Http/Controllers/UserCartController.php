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
            ->where('paid', 'unpaid')
            ->where('status', 'pending')
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
        $car_number = $request->car_number_letters1 . '' . $request->car_number_letters2 . '' . $request->car_number_letters3 . '' . ' ' . $request->car_number_digits;

        $worker = User::where('role', 'supervisor')
            // ->where('city', 'like', '%' . $user->city . '%')
            // ->withCount('factorCart')
            // ->orderBy('factor_cart_count', 'asc')
            ->first();

        if (!$worker) {
            $worker = User::where('role', 'supervisor')
                // ->where(function ($query) use ($user) {
                //     $query->where('city', '!=', $user->city)->orWhereNull('city');
                // })
                // ->withCount('factorCart')
                // ->orderBy('factor_cart_count', 'asc')
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
        ], [
            'product_id.required' => 'معرّف المنتج مطلوب.',
            'product_id.exists' => 'المنتج المحدد غير موجود.',
            'car_model.required' => 'نموذج السيارة مطلوب.',
            'car_model.exists' => 'نموذج السيارة المحدد غير موجود.',
            'car_color.required' => 'لون السيارة مطلوب.',
            'car_color.string' => 'يجب أن يكون لون السيارة نصًا.',
            'car_color.max' => 'لون السيارة يجب ألا يتجاوز 50 حرفًا.',
            'car_wash.required' => 'تاريخ الغسيل مطلوب.',
            'car_wash.date' => 'يجب أن يكون تاريخ الغسيل تاريخًا صالحًا.',
            'car_type.required' => 'نوع السيارة مطلوب.',
            'car_type.string' => 'نوع السيارة يجب أن يكون نصًا.',
            'car_type.max' => 'نوع السيارة يجب ألا يتجاوز 20 حرفًا.',
            'price.required' => 'السعر مطلوب.',
            'price.numeric' => 'يجب أن يكون السعر رقمًا.',
            'price.min' => 'السعر يجب أن يكون على الأقل 0.',
            'latitude.required' => 'خط العرض مطلوب.',
            'longitude.required' => 'خط الطول مطلوب.',
        ]);

        $cart = $user->userCart()->create(array_merge($validatedData, [
            'customer_id' => $user->id,
            'factor_id' => $worker->id,
            'car_number' => $car_number
        ]));

        return redirect()->back()->with('success', 'تم إضافة الطلب في السلة بنجاح');
    }

    public function updatePayment(Request $request)
    {
        $paymentMethod = $request->input('payment_method');

        // تحديث طريقة الدفع لجميع الطلبات في العربة

        Cart::query()
            ->where('paid', 'unpaid')
            ->update(['paid' => $paymentMethod]);

        return redirect()->back()->with('success', 'تم تحديث طريقة الدفع بنجاح.');
    }


    public function addReferenceNumber(Request $request)
    {
        // التحقق من صحة الإدخالات
        $request->validate([
            'reference_number' => 'required_if:payment_method,mada|string|max:255',
            'cart_id' => 'required|exists:carts,id',
        ], [
            'reference_number.required_if' => 'رقم المرجع مطلوب عند اختيار مدى.',
            'reference_number.string' => 'رقم المرجع يجب أن يكون نصًا.',
            'reference_number.max' => 'رقم المرجع يجب ألا يتجاوز 255 حرفًا.',
            'cart_id.required' => 'معرّف السلة مطلوب.',
            'cart_id.exists' => 'السلة المحددة غير موجودة.',
        ]);

        // الحصول على البيانات
        $referenceNumber = $request->input('reference_number');
        $cart = Cart::find($request->input('cart_id'));

        // تحديث رقم المرجع
        $cart->reference_number = $referenceNumber;
        $cart->save();

        return redirect()->back()->with('success', 'تم تحديث رقم المرجع بنجاح.');
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();
        return redirect()->back()->with('success', 'تم حذف الطلب بنجاح.');
    }

}
