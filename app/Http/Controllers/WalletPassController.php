<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pkpass\Pkpass;
use App\Models\WalletTemplate;
use App\Models\User;

class WalletPassController extends Controller
{
    public function generateApplePass(User $user)
    {
        // 1. التحقق من أن المستخدم عميل
        if (!$user->isCustomer()) {
            abort(404, 'User is not a customer.');
        }

        // 2. جلب قالب بطاقة آبل النشط من قاعدة البيانات
        $template = WalletTemplate::where('platform', 'apple')->where('is_active', true)->first();
        if (!$template) {
            abort(500, 'Active Apple Wallet template not found.');
        }

        try {
            // 3. إعداد بيانات البطاقة
            // ستحتاج إلى شهادات من حساب مطوري آبل وتخزينها بأمان
            $pass = new Pkpass(config('services.apple.pass_certificate_path'), config('services.apple.pass_certificate_password'));

            $pass->setData([
                'passTypeIdentifier' => $template->pass_type_id,
                'formatVersion' => 1,
                'serialNumber' => $user->qr_code_identifier,
                'teamIdentifier' => config('services.apple.team_id'),
                'organizationName' => 'اسم شركتك',
                'description' => 'بطاقة ولاء العملاء',
                'logoText' => $template->logo_text,
                'foregroundColor' => $template->foreground_color,
                'backgroundColor' => $template->background_color,
                'labelColor'    => $template->label_color,
                'loyalty' => [
                    'primaryFields' => [
                        [
                            'key' => 'points',
                            'label' => 'النقاط',
                            'value' => $user->points,
                        ],
                    ],
                    'secondaryFields' => [
                        [
                            'key' => 'customerName',
                            'label' => 'اسم العميل',
                            'value' => $user->name,
                        ],
                    ],
                ],
            ]);

            // 4. إضافة الصور اللازمة للبطاقة (icon, logo)
            // $pass->addFile(public_path('images/wallet/icon.png'));
            // $pass->addFile(public_path('images/wallet/logo.png'));

            // 5. إنشاء وتنزيل الملف
            $pass->create(true);
        } catch (\Exception $e) {
            \Log::error("Apple Pass Generation Failed for user {$user->id}: " . $e->getMessage());
            abort(500, 'حدث خطأ أثناء إنشاء بطاقتك.');
        }
    }
}
