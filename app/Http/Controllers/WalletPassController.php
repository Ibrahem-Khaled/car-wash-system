<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Thenextweb\PassGenerator;
use Illuminate\Support\Str;


class WalletPassController extends Controller
{
    public function generateLoyaltyPass(User $user)
    {
        // 1. حساب نقاط الولاء الحالية
        // نفترض أن كل خدمة غير مجانية تضيف نقطة
        $loyaltyPoints = $user->serviceLogs()->where('is_reward', false)->count();

        // لنفترض أن الهدية تُمنح كل 10 نقاط
        $REWARD_THRESHOLD = 10;
        $pointsNeeded = $REWARD_THRESHOLD - ($loyaltyPoints % $REWARD_THRESHOLD);
        if ($pointsNeeded == $REWARD_THRESHOLD) {
            $pointsNeeded = 0; // إذا كان لديه 10 أو 20 نقطة، فهو يستحق هدية الآن
        }

        // 2. إنشاء كائن PassGenerator
        // نستخدم معرّف العميل لتمييز البطاقة
        $pass = new PassGenerator(Str::uuid()->toString());

        // 4. بناء تعريف البطاقة (من نوع storeCard)
        $pass_definition = [
            "description"        => "Your Loyalty Card",
            "formatVersion"      => 1,
            "organizationName"   => "velvet-vehicle",
            "passTypeIdentifier" => env('PASS_TYPE_IDENTIFIER'), // يجب أن يكون ثابتًا
            "serialNumber"       => Str::uuid()->toString(), // رقم تسلسلي فريد لكل مرة يتم فيها إنشاء البطاقة
            "teamIdentifier"     => env('TEAM_IDENTIFIER'),
            "foregroundColor"    => "rgb(255, 255, 255)",
            "backgroundColor"    => "rgb(60, 65, 70)",
            "logoText"           => "Velvet Loyalty",
            "barcode" => [
                "message"         => (string) $user->id, // رسالة الباركود هي معرّف العميل ليسهل مسحه ضوئيًا
                "format"          => "PKBarcodeFormatQR",
                "altText"         => (string) $user->id,
                "messageEncoding" => "utf-8",
            ],
            // استخدام "storeCard" بدلاً من "boardingPass"
            "storeCard" => [
                "primaryFields" => [
                    [
                        "key"   => "points",
                        "label" => "Current Points",
                        "value" => $loyaltyPoints,
                    ]
                ],
                "secondaryFields" => [
                    [
                        "key"   => "customerName",
                        "label" => "Customer",
                        "value" => $user->name,
                    ]
                ],
                "auxiliaryFields" => [
                    [
                        "key"   => "rewardInfo",
                        "label" => "Next Reward",
                        "value" => $pointsNeeded > 0 ? "Only {$pointsNeeded} visits left for a gift!" : "You've earned a gift!",
                    ]
                ],
            ],
        ];

        // تعيين تعريف البطاقة
        $pass->setPassDefinition($pass_definition);

        // 5. إضافة الصور (Assets)
        $pass->addAsset(public_path('images/wallet/icon.png'));
        $pass->addAsset(public_path('images/wallet/logo.png'));

        // 6. إنشاء ملف pkpass
        $pkpass_content = $pass->create();

        // 7. إرجاع الملف كـ response لتنزيله
        $filename = 'loyalty-card-' . $user->id . '.pkpass';

        return response($pkpass_content, 200, [
            'Content-Transfer-Encoding' => 'binary',
            'Content-Description'       => 'File Transfer',
            'Content-Disposition'       => 'attachment; filename="' . $filename . '"',
            'Content-length'            => strlen($pkpass_content),
            'Content-Type'              => $pass->getPassMimeType(),
            'Pragma'                    => 'no-cache',
        ]);
    }
}
