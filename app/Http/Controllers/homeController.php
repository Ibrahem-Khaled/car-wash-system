<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class homeController extends Controller
{
    protected $companyUser;

    // Constructor to initialize the company user
    public function __construct()
    {
        $this->companyUser = User::where('role', 'company')->first();
    }

    // Home page method
    public function index()
    {
        $products = Product::all();
        return view('home', [
            'products' => $products,
            'companyUser' => $this->companyUser,
        ]);
    }

    // Contact us page method
    public function contactUs()
    {
        return view('contact-us', [
            'companyUser' => $this->companyUser,
        ]);
    }

    // Handle contact us form submission
    public function contactUsPost(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'message' => 'required',
        ]);

        ContactUs::create($request->all());

        return redirect()->back()->with('success', 'تم الارسال بنجاح');
    }

    // About us page method
    public function aboutUs()
    {
        return view('about-us', [
            'companyUser' => $this->companyUser,
        ]);
    }
}
