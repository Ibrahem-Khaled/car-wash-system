<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;


class CheckOtpVerification
{
    public function handle(Request $request, Closure $next)
    {
        // التحقق مما إذا كان المستخدم مسجل الدخول
        if (Auth::check()) {
            // التحقق مما إذا كان المستخدم قد تحقق من OTP
            if (!Session::get('otp_verified', false)) {
                // إعادة التوجيه إلى صفحة إدخال OTP إذا لم يتم التحقق
                return redirect()->route('otp')->with('error', 'يرجى التحقق من رمز OTP للوصول.');
            }
        }

        return $next($request);
    }
}
