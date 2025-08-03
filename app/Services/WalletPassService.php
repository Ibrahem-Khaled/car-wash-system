<?php

namespace App\Services;

use App\Models\User;
use App\Models\WalletTemplate;

class WalletPassService
{
    /**
     * إنشاء بيانات بطاقة Wallet لمنصة معينة.
     *
     * @param User $customer
     * @param string $platform 'google' or 'apple'
     * @return array
     */
    public function generatePassData(User $customer, string $platform): array
    {
        $template = WalletTemplate::where('platform', $platform)->where('is_active', true)->first();
        if (!$template) {
            return ['error' => "No active wallet template found for {$platform}."];
        }

        // حساب بيانات الولاء
        $totalServices = $customer->services_count;
        $servicesTarget = \App\Http\Controllers\LoyaltyController::SERVICES_TARGET;
        $currentCycleServices = $totalServices % $servicesTarget;

        if ($platform === 'google') {
            return $this->generateGooglePass($customer, $template, $currentCycleServices, $servicesTarget);
        }

        if ($platform === 'apple') {
            return $this->generateApplePass($customer, $template);
        }

        return [];
    }

    /**
     * يجهز بيانات لإنشاء زر "Add to Google Wallet".
     */
    private function generateGooglePass(User $customer, WalletTemplate $template, int $currentServices, int $target): array
    {
        // يتطلب: composer require google/apiclient
        // هذا مجرد مثال توضيحي لكيفية بناء الـ JWT
        $classId = $template->pass_type_id;
        $objectId = "{$classId}.{$customer->qr_code_identifier}";

        $payload = [
            'iss' => config('services.google.wallet_issuer_email'),
            'aud' => 'google',
            'typ' => 'savetowallet',
            'origins' => [request()->getSchemeAndHttpHost()],
            'payload' => [
                'loyaltyObjects' => [[
                    'id' => $objectId,
                    'classId' => $classId,
                    'state' => 'ACTIVE',
                    'heroImage' => [ /* ... */],
                    'textModulesData' => [ /* ... */],
                    'linksModuleData' => [ /* ... */],
                    'loyaltyPoints' => [
                        'label' => 'النقاط',
                        'balance' => ['string' => (string)$customer->points],
                    ],
                    // ... المزيد من الخصائص لتصميم البطاقة
                ]]
            ]
        ];

        // في الكود الفعلي، ستقوم بتوقيع هذا الـ payload باستخدام مفتاح الخدمة الخاص بك
        // $signedJwt = ... sign with your private key ...;

        return [
            'success' => true,
            'signedJwt' => "DUMMY_JWT_FOR_" . $customer->id, // هذا مجرد مثال، يجب توليد JWT حقيقي
        ];
    }

    /**
     * يجهز رابط لتنزيل ملف .pkpass لـ Apple Wallet.
     */
    private function generateApplePass(User $customer, WalletTemplate $template): array
    {
        // يتطلب: composer require pkpass/pkpass
        // الخدمة هنا لا تنشئ الملف مباشرة، بل تعيد رابطاً آمناً لتنزيله.
        return [
            'success' => true,
            // هذا الراوت سيقوم بإنشاء وتنزيل الملف عند طلبه
            'downloadUrl' => route('wallet.apple.generate', $customer->id),
        ];
    }
}
