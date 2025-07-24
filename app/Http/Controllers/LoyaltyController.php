<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ServiceLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoyaltyController extends Controller
{
    /**
     * عدد الخدمات المطلوبة للحصول على الهدية.
     */
    const SERVICES_TARGET = 5;

    /**
     * معالجة مسح الـ QR Code، إضافة خدمة، ومنح الهدية تلقائيًا.
     *
     * @param string $identifier
     * @return \Illuminate\Http\RedirectResponse
     */
    public function scan($identifier)
    {
        // البحث عن العميل باستخدام معرّف الكيو آر
        $customer = User::where('qr_code_identifier', $identifier)
            ->where('role', User::ROLE_CUSTOMER)
            ->firstOrFail();

        // 1. إضافة سجل الخدمة الحالية التي تم مسحها
        ServiceLog::create([
            'customer_id' => $customer->id,
            'scanned_by_user_id' => Auth::id(),
            'is_reward' => false, // هذه خدمة عادية مدفوعة
        ]);

        // 2. إعادة حساب عدد الخدمات الحالية (غير الهدايا)
        $currentServicesCount = $customer->serviceLogs()->where('is_reward', false)->count();

        // 3. التحقق مما إذا كان العميل قد وصل للهدف
        if ($currentServicesCount >= self::SERVICES_TARGET) {

            // تهانينا! العميل يستحق هدية.

            // أ. "استهلاك" الخدمات التي أدت للهدية عن طريق حذفها
            $customer->serviceLogs()
                ->where('is_reward', false)
                ->orderBy('created_at', 'asc') // نضمن حذف أقدم الخدمات أولاً
                ->take(self::SERVICES_TARGET)
                ->delete();

            // ب. إضافة سجل الهدية للعميل نفسه
            ServiceLog::create([
                'customer_id' => $customer->id,
                'scanned_by_user_id' => Auth::id(),
                'is_reward' => true,
                'gifted_to_phone_number' => $customer->phone_number, // الهدية لنفس رقم العميل
            ]);

            // ج. تجهيز رسالة النجاح
            $message = "🎉 تهانينا! لقد ربحت خدمة مجانية وتمت إضافتها لحسابك مباشرة.";
        } else {
            // لم يصل للهدف بعد
            $remaining = self::SERVICES_TARGET - $currentServicesCount;
            $message = "تمت إضافة خدمة بنجاح. متبقي {$remaining} خدمة للحصول على الهدية القادمة.";
        }

        // 4. إعادة التوجيه إلى صفحة العميل لعرض الإحصائيات المحدثة والرسالة
        return redirect()->route('customers.show', $customer->id)->with('success', $message);
    }

    public function useGift(User $user)
    {
        // ابحث عن أقدم هدية غير مستخدمة لهذا العميل
        $giftToUse = $user->serviceLogs()
            ->where('is_reward', true)
            ->where('is_used', false)
            ->orderBy('created_at', 'asc')
            ->first();

        // إذا لم توجد هدية (كإجراء احترازي)، قم بإعادة التوجيه مع رسالة خطأ
        if (!$giftToUse) {
            return redirect()->route('customers.show', $user->id)
                ->with('error', 'لا توجد هدايا متاحة للاستخدام حالياً.');
        }

        // قم بتحديث سجل الهدية لتمييزها كمستخدمة
        $giftToUse->update(['is_used' => true]);

        // أعد التوجيه مع رسالة نجاح
        return redirect()->route('customers.show', $user->id)
            ->with('success', 'تم استخدام الخدمة المجانية بنجاح!');
    }
}
