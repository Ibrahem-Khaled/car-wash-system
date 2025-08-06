<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\WalletTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use SimpleSoftwareIO\QrCode\Facades\QrCode; // <-- إضافة: استيراد مكتبة QR Code



class WalletTemplateController extends Controller
{
    public function edit()
    {
        // جلب قالب آبل أو إنشاء واحد جديد إذا لم يكن موجودًا
        $appleTemplate = WalletTemplate::firstOrCreate(
            ['platform' => 'apple'],
            [
                'pass_type_id' => 'pass.com.example.coupon',
                'logo_text' => 'Your Brand',
                'background_color' => '#6f42c1',
                'foreground_color' => '#ffffff',
                'label_color' => '#eeeeee',
                'is_active' => true,
            ]
        );

        $user = auth()->user();
        $qrCodeSvg = QrCode::size(140)
            ->backgroundColor(255, 255, 255) // خلفية بيضاء للـ QR
            ->margin(1)
            ->generate(route('loyalty.scan', $user->qr_code_identifier));

        // جلب قالب جوجل أو إنشاء واحد جديد إذا لم يكن موجودًا
        $googleTemplate = WalletTemplate::firstOrCreate(
            ['platform' => 'google'],
            [
                'pass_type_id' => 'YOUR_PASS_CLASS_ID',
                'logo_text' => 'Your Brand',
                'background_color' => '#1976d2',
                'foreground_color' => '#ffffff',
                'label_color' => '#eeeeee',
                'is_active' => true,
            ]
        );

        return view('dashboard.loyalty.wallet', compact('appleTemplate', 'googleTemplate', 'qrCodeSvg'));
    }

    /**
     * تحديث بيانات قالب المحفظة.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // التحقق من نوع المنصة (آبل أو جوجل)
        $platform = $request->input('platform');
        if (!in_array($platform, ['apple', 'google'])) {
            return back()->withErrors(['platform' => 'المنصة المحددة غير صالحة.']);
        }

        // التحقق من صحة البيانات المدخلة
        $validator = Validator::make($request->all(), [
            'platform' => ['required', Rule::in(['apple', 'google'])],
            'pass_type_id' => 'required|string|max:255',
            'logo_text' => 'required|string|max:100',
            'background_color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
            'foreground_color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
            'label_color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $validatedData = $validator->validated();
        // التأكد من أن is_active يأخذ قيمة false إذا لم يتم إرساله
        $validatedData['is_active'] = $request->has('is_active');


        // تحديث القالب أو إنشاؤه إذا لم يكن موجودًا
        WalletTemplate::updateOrCreate(
            ['platform' => $platform],
            $validatedData
        );

        return redirect()->route('wallet.edit')->with('success', 'تم تحديث قالب ' . ucfirst($platform) . ' بنجاح!');
    }
}
