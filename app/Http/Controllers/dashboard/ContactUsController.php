<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function index()
    {
        $contacts = ContactUs::all();
        return view('dashboard.contact', compact('contacts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required',
        ]);

        ContactUs::create($request->all());
        return redirect()->back()->with('success', 'تم إرسال الرسالة بنجاح');
    }

    public function update(Request $request, ContactUs $contact)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required',
        ]);

        $contact->update($request->all());
        return redirect()->back()->with('success', 'تم تحديث الرسالة بنجاح');
    }

    public function destroy(ContactUs $contact)
    {
        $contact->delete();
        return redirect()->back()->with('success', 'تم حذف الرسالة بنجاح');
    }
}
