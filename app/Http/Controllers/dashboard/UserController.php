<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * عرض صفحة إدارة المستخدمين مع الإحصائيات والفلترة.
     */
    public function index(Request $request)
    {
        // جلب الأدوار المتاحة من جدول المستخدمين مباشرة
        $roles = User::select('role')->distinct()->pluck('role')->toArray();

        // جلب الدور المختار من الرابط، الافتراضي هو 'all'
        $selectedRole = $request->get('role', 'all');

        // الاستعلام الأساسي للمستخدمين
        $query = User::query();

        // فلترة حسب الدور إذا تم اختيار دور معين
        if ($selectedRole !== 'all') {
            $query->where('role', $selectedRole);
        }

        // فلترة حسب البحث (الاسم، البريد الإلكتروني، الهاتف)
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('email', 'like', "%{$searchTerm}%")
                    ->orWhere('phone', 'like', "%{$searchTerm}%");
            });
        }

        // جلب المستخدمين مع الترقيم
        $users = $query->latest()->paginate(10)->withQueryString();
        $users->each(function ($user) {
            // نتأكد أن الراوت موجود وأن المستخدم لديه المعرّف اللازم
            if ($user->qr_code_identifier) {
                // استخدام الراوت الجديد الذي وفرته
                $user->qrCodeUrl = route('customers.show', $user);
            }
        });
        // حساب الإحصائيات
        $stats = [
            'total' => User::count(),
            'active' => User::where('status', 'active')->count(),
            'inactive' => User::where('status', 'inactive')->count(),
            'roles_count' => count($roles),
        ];

        // مصفوفة لترجمة أسماء الأدوار إلى العربية
        $roleNames = $this->getRoleNames();

        return view('dashboard.users.index', compact('users', 'roles', 'selectedRole', 'stats', 'roleNames'));
    }

    /**
     * تخزين مستخدم جديد في قاعدة البيانات.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in(['admin', 'customer', 'factor', 'company', 'supervisor'])],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('password', 'image');
        $data['password'] = Hash::make($request->password);

        // إنشاء QR Code فريد
        $data['qr_code_identifier'] = Str::random(32);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('users/avatars', 'public');
        } else {
            // استخدام الصورة الافتراضية
            $data['image'] = 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ftse1.mm.bing.net%2Fth%3Fid%3DOIP.jQvFuRlmVesA7K6ArjfyrAHaH9%26pid%3DApi%26h%3D160&f=1&ipt=cf445510efbffaae5e0ba584d6e07fd887ed3424659c89452cd311e407bb287d&ipo=images';
        }

        User::create($data);

        return redirect()->route('users.index')->with('success', 'تمت إضافة المستخدم بنجاح!');
    }

    /**
     * تحديث بيانات مستخدم موجود.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'string', 'max:20', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => ['required', Rule::in(['admin', 'customer', 'factor', 'company', 'supervisor'])],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('password', 'image');

        // تحديث كلمة المرور فقط إذا تم إدخالها
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // تحديث الصورة إذا تم رفع صورة جديدة
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إذا كانت موجودة وليست الصورة الافتراضية
            if ($user->image && Storage::disk('public')->exists($user->image) && !Str::startsWith($user->image, 'http')) {
                Storage::disk('public')->delete($user->image);
            }
            $data['image'] = $request->file('image')->store('users/avatars', 'public');
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'تم تحديث بيانات المستخدم بنجاح!');
    }

    /**
     * حذف مستخدم من قاعدة البيانات.
     */
    public function destroy(User $user)
    {
        // حذف صورة المستخدم إذا كانت موجودة
        if ($user->image && Storage::disk('public')->exists($user->image) && !Str::startsWith($user->image, 'http')) {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'تم حذف المستخدم بنجاح!');
    }

    /**
     * دالة مساعدة لترجمة أسماء الأدوار.
     */
    private function getRoleNames()
    {
        return [
            'admin' => 'مدير',
            'customer' => 'زبون',
            'factor' => 'عامل',
            'company' => 'شركة',
            'supervisor' => 'مشرف',
        ];
    }
}
