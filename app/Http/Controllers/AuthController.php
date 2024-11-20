<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use TaqnyatSms;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('home')->with('success', 'تم تسجيل الدخول بنجاح.');
        }
        Session::forget(['otp_code', 'otp_verified']); // إزالة حالة التحقق من OTP عند عرض صفحة تسجيل الدخول
        return view('Auth.login');
    }

    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            Session::put('otp_verified', false); // ضبط حالة التحقق من OTP على غير محقق
            return redirect()->route('otp')->with('info', 'يرجى إدخال رمز التحقق OTP.');
        } else {
            return redirect()->back()->with('error', 'تفاصيل تسجيل الدخول غير صحيحة. يرجى المحاولة مرة أخرى.');
        }
    }

    public function register()
    {
        if (Auth::check()) {
            return redirect()->route('home')->with('success', 'تم تسجيل الدخول بنجاح.');
        }
        Session::forget(['otp_code', 'otp_verified']); // إزالة حالة التحقق من OTP عند عرض صفحة التسجيل
        return view('Auth.register');
    }

    public function customRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:6|confirmed',
            'phone' => 'required|numeric|unique:users',
            'address' => 'nullable|string|max:255',
        ]);

        $data = $request->only('name', 'email', 'password', 'phone', 'address');
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        Auth::login($user);
        Session::put('otp_verified', false);
        return redirect()->route('otp')->with('info', 'يرجى إدخال رمز التحقق OTP.');
    }

    public function otp()
    {
        // Session::put('otp_verified', true);
        // return redirect()->route('home')->with('info', 'يرجى إدخال رمز التحقق OTP.');
        // التحقق من حالة التحقق من OTP
        if (Session::get('otp_verified') === true) {
            return redirect()->route('home');
        }

        // التحقق من وجود مستخدم مسجل الدخول
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'يرجى تسجيل الدخول أولاً.');
        }

        // إنشاء رمز OTP عشوائي فقط عند طلب جديد
        if (!Session::has('otp_code')) {
            $otp = rand(10000, 99999);
            Session::put('otp_code', $otp);

            // محتوى الرسالة المحسّن
            $body = "رمز التحقق للدخول إلى منصة velvet هو: $otp. يرجى إدخال الرمز لإكمال التحقق.";
            $recipients = [Auth::user()->phone ?? ''];
            $sender = 'velvet';
            $smsId = auth()->user()->id;

            try {
                if (empty($recipients[0])) {
                    throw new \Exception('رقم الهاتف غير متوفر.');
                }

                $taqnyt = new TaqnyatSms(env('OTP_TAQNYAT_BEARER'));
                $message = $taqnyt->sendMsg($body, $recipients, $sender, $smsId);

                Log::info('Message sent response:', (array) $message);
            } catch (\Exception $e) {
                // تسجيل الخطأ
                Log::error('Error sending OTP:', ['error' => $e->getMessage()]);
                return redirect()->back()->with('error', 'حدث خطأ أثناء إرسال رمز التحقق. يرجى المحاولة مرة أخرى.');
            }
        }

        return view('Auth.otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:5',
        ]);
        if ($request->input('otp') == Session::get('otp_code')) {
            Session::put('otp_verified', true);
            Session::forget('otp_code');
            return redirect()->route('home')->with('success', 'تم التحقق من OTP بنجاح.');
        } else {
            return redirect()->back()->with('error', 'رمز OTP غير صحيح. يرجى المحاولة مرة أخرى.');
        }
    }

    public function logout()
    {
        Auth::logout();
        Session::forget('otp_verified');
        return redirect()->route('home')->with('success', 'تم تسجيل الخروج بنجاح.');
    }

    public function forgetPassword()
    {
        return view('Auth.forgetPassword');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'المستخدم غير موجود.');
        }

        // منطق إرسال رابط إعادة تعيين كلمة المرور
        return redirect()->back()->with('success', 'تم إرسال رابط إعادة تعيين كلمة المرور إلى بريدك الإلكتروني.');
    }

    public function profile()
    {
        $companyUser = User::where('role', 'company')->first();
        $user = User::find(Auth::id());
        return view('Auth.profile', compact('user', 'companyUser'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user = Auth::user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();

        return redirect()->back()->with('success', 'تم تحديث الملف الشخصي بنجاح.');
    }


    public function destroy()
    {
        Auth::user()->delete();
        return redirect()->route('home')->with('success', 'تم حذف الحساب بنجاح.');
    }
}
