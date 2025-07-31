<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\SlideShow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlideShowController extends Controller
{
    public function index(Request $request)
    {
        // الاستعلام الأساسي للشرائح
        $query = SlideShow::query();

        // البحث عن شريحة
        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        // جلب الشرائح مع الترقيم
        $slideShows = $query->latest()->paginate(10);

        // حساب الإحصائيات
        $stats = [
            'total' => SlideShow::count(),
            'active' => SlideShow::where('status', 'active')->count(),
            'inactive' => SlideShow::where('status', 'inactive')->count(),
        ];

        return view('dashboard.slide_shows.index', compact('slideShows', 'stats'));
    }

    /**
     * تخزين شريحة جديدة في قاعدة البيانات.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'link' => 'nullable|url|max:255',
            'status' => 'required|in:active,inactive',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('slide_shows', 'public');
        }

        SlideShow::create($data);

        return redirect()->route('slide_shows.index')->with('success', 'تمت إضافة الشريحة بنجاح.');
    }

    /**
     * تحديث بيانات شريحة موجودة.
     */
    public function update(Request $request, SlideShow $slideShow)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'link' => 'nullable|url|max:255',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($slideShow->image) {
                Storage::disk('public')->delete($slideShow->image);
            }
            $data['image'] = $request->file('image')->store('slide_shows', 'public');
        }

        $slideShow->update($data);

        return redirect()->route('slide_shows.index')->with('success', 'تم تحديث الشريحة بنجاح.');
    }

    /**
     * حذف شريحة من قاعدة البيانات.
     */
    public function destroy(SlideShow $slideShow)
    {
        // حذف الصورة المرتبطة
        if ($slideShow->image) {
            Storage::disk('public')->delete($slideShow->image);
        }

        $slideShow->delete();

        return redirect()->route('slide_shows.index')->with('success', 'تم حذف الشريحة بنجاح.');
    }
}
