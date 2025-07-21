<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class CustomerManagementController extends Controller
{
    // عرض فورم إضافة عميل
    public function create()
    {
        return view('customers.create');
    }

    // تخزين العميل الجديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|unique:users,phone',
        ]);

        // إنشاء مستخدم جديد برتبة "عميل"
        $customer = User::create([
            'name' => $request->name,
            'phone' => $request->phone_number,
            'password' => Hash::make(Str::random(10)), // كلمة سر عشوائية لأنه لن يسجل الدخول
            'role' => User::ROLE_CUSTOMER,
            'qr_code_identifier' => (string) Str::uuid(),
        ]);

        return redirect()->route('customers.show', $customer->id)
            ->with('success', 'تم إضافة العميل بنجاح. هذا هو الـ QR Code الخاص به.');
    }

    // عرض بيانات العميل والـ QR Code
    public function show(User $user)
    {
        // تأكد أن المستخدم الذي يتم عرضه هو عميل
        if (!$user->isCustomer()) {
            abort(404, 'المستخدم المطلوب ليس عميلاً.');
        }

        // جلب البيانات اللازمة من المودل والمتحكم الآخر
        $totalServices = $user->serviceLogs()->where('is_reward', false)->count();
        $totalGifts = $user->serviceLogs()->where('is_reward', true)->count();
        $servicesTarget = LoyaltyController::SERVICES_TARGET;

        // حساب عدد الخدمات المتبقية للوصول للهدية التالية
        // نستخدم المعامل % (موديولو) لحساب الخدمات الحالية في الدورة الحالية
        $currentCycleServices = $totalServices % $servicesTarget;
        $remainingForGift = ($currentCycleServices == 0 && $totalServices > 0) ? 0 : $servicesTarget - $currentCycleServices;

        // الرابط الذي سيتم تضمينه في الـ QR Code
        $qrCodeUrl = route('loyalty.scan', $user->qr_code_identifier);

        // تمرير كل البيانات إلى الواجهة
        return view('customers.show', [
            'user' => $user,
            'qrCodeUrl' => $qrCodeUrl,
            'totalServices' => $totalServices,
            'totalGifts' => $totalGifts,
            'remainingForGift' => $remainingForGift,
            'servicesTarget' => $servicesTarget,
        ]);
    }
}
