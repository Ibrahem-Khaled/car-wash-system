<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class SettingController extends Controller
{
    public function edit()
    {
        // Find the first user with the role 'company' to represent site settings
        // If it doesn't exist, create a new one with default values.
        $settings = User::firstOrCreate(
            ['role' => 'company'],
            [
                'name' => 'Your Company Name',
                'email' => 'contact@yourcompany.com',
                'phone' => '1234567890',
                'password' => Hash::make('DefaultPassword!'), // Set a default secure password
                'status' => 'active',
            ]
        );

        return view('dashboard.settings.edit', compact('settings'));
    }

    /**
     * Update the site settings in storage.
     */
    public function update(Request $request)
    {
        // Find the settings user
        $settingsUser = User::where('role', 'company')->firstOrFail();

        // Validate the incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($settingsUser->id),
            ],
            'phone' => [
                'nullable',
                'string',
                Rule::unique('users')->ignore($settingsUser->id),
            ],
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Added image validation
        ]);

        // Update the user's data
        $settingsUser->name = $request->name;
        $settingsUser->email = $request->email;
        $settingsUser->phone = $request->phone;
        $settingsUser->address = $request->address;
        $settingsUser->city = $request->city;

        // Handle file upload for the image
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('settings', 'public');
            $settingsUser->image = $path;
        }

        $settingsUser->save();

        return redirect()->back()->with('success', 'تم تحديث بيانات الموقع بنجاح!');
    }
}
