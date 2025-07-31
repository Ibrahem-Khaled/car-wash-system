<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ContactUsController extends Controller
{
 public function index(Request $request)
    {
        $query = ContactUs::query();

        // فلترة البحث
        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
        }

        $messages = $query->latest()->paginate(15);

        // حساب الإحصائيات
        $stats = [
            'total' => ContactUs::count(),
            'today' => ContactUs::whereDate('created_at', Carbon::today())->count(),
        ];

        return view('dashboard.contact_us.index', compact('messages', 'stats'));
    }

    /**
     * عرض تفاصيل رسالة واحدة (سيتم استخدامه داخل المودال).
     * هذه الدالة ليست ضرورية إذا كانت كل البيانات تُمرر للـ view مباشرة,
     * لكنها مفيدة في حال أردت عمل استدعاء AJAX في المستقبل.
     */
    public function show(ContactUs $contactUs)
    {
        return view('dashboard.contact_us.show', compact('contactUs'));
    }


    /**
     * حذف رسالة.
     */
    public function destroy(ContactUs $contactUs)
    {
        $contactUs->delete();
        return redirect()->route('contact_us.index')->with('success', 'تم حذف الرسالة بنجاح.');
    }
}
