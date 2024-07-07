<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\SlideShow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlideShowController extends Controller
{
    public function index()
    {
        $slides = SlideShow::paginate(10);
        return view('dashboard.slide_shows', compact('slides'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:active,inactive',
            'link' => 'nullable|string|max:255',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        SlideShow::create($data);

        return redirect()->back()->with('success', 'Slide Show created successfully.');
    }

    public function update(Request $request, SlideShow $slide)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:active,inactive',
            'link' => 'nullable|string|max:255',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($slide->image) {
                Storage::disk('public')->delete($slide->image);
            }
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        $slide->update($data);

        return redirect()->back()->with('success', 'Slide Show updated successfully.');
    }

    public function destroy(SlideShow $slide)
    {
        if ($slide->image) {
            Storage::disk('public')->delete($slide->image);
        }
        $slide->delete();
        return redirect()->back()->with('success', 'Slide Show deleted successfully.');
    }
}
