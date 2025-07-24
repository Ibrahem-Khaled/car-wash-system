<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Services\WalletPassService; // <-- إضافة مهمة
use Illuminate\Support\Facades\Log;

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
            // تحسين التحقق من صحة رقم الهاتف
            'phone' => 'required|string|unique:users,phone',
        ], [
            'phone.unique' => 'رقم الهاتف هذا مسجل بالفعل.',
            'phone.regex' => 'الرجاء إدخال رقم هاتف مصري صحيح.'
        ]);

        try {
            $customer = User::create([
                'name' => $request->name,
                'phone' => $request->phone,
                // كلمة سر عشوائية قوية
                'password' => Hash::make(Str::random(16)),
                'role' => User::ROLE_CUSTOMER,
                'status' => 'active',
                'qr_code_identifier' => (string) Str::uuid(),
            ]);

            // توجيه العميل إلى صفحته الشخصية مع رسالة ترحيب
            return redirect()->route('customers.show', $customer)
                ->with('success', 'أهلاً بك! تم إنشاء بطاقة الولاء الخاصة بك بنجاح.');
        } catch (\Exception $e) {
            Log::error('Failed to create customer: ' . $e->getMessage());
            return back()->with('error', 'حدث خطأ غير متوقع، الرجاء المحاولة مرة أخرى.')->withInput();
        }
    }

    // عرض بيانات العميل والـ QR Code
    public function show(User $user, WalletPassService $walletService)
    {
        // تأكد أن المستخدم الذي يتم عرضه هو عميل
        if (!$user->isCustomer()) {
            abort(404, 'المستخدم المطلوب ليس عميلاً.');
        }

        // جلب البيانات اللازمة من المودل والمتحكم الآخر
        $servicesTarget = LoyaltyController::SERVICES_TARGET;

        $qrCodeUrl = route('loyalty.scan', $user->qr_code_identifier);

        $googlePassData = $walletService->generatePassData($user, 'google');
        $applePassData = $walletService->generatePassData($user, 'apple');


        $loyaltyData = [
            'totalServices' => $user->serviceLogs()->where('is_reward', false)->count(),
            'totalGifts' => $user->serviceLogs()->where('is_reward', true)->count(),
            'unusedGiftsCount' => $user->serviceLogs()->where('is_reward', true)->where('is_used', false)->count(),
            'remainingForGift' => ($user->serviceLogs()->where('is_reward', false)->count() == 0) ? 0 : $servicesTarget - $user->serviceLogs()->where('is_reward', false)->count(),
            'currentCycleServices' => $user->serviceLogs()->where('is_reward', false)->count() % $servicesTarget
        ];

        // تمرير كل البيانات إلى الواجهة
        return view('customers.show', [
            'user' => $user,
            'qrCodeUrl' => $qrCodeUrl,
            'servicesTarget' => $servicesTarget,
            'googlePassData' => $googlePassData, // <-- تمرير بيانات جوجل
            'applePassData' => $applePassData,   // <-- تمرير بيانات آبل
            'loyalty' => $loyaltyData,

        ]);
    }
}
