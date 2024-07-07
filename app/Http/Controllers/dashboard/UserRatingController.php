<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserRating;
use Illuminate\Http\Request;

class UserRatingController extends Controller
{
    public function index()
    {
        $ratings = UserRating::paginate(10);
        $users = User::all();
        $factors = User::where('role', 'factor')->get();
        return view('dashboard.user_ratings', compact('ratings', 'users', 'factors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'factor_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        UserRating::create($request->all());

        return redirect()->back()->with('success', 'Rating created successfully.');
    }

    public function update(Request $request, UserRating $rating)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'factor_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $rating->update($request->all());

        return redirect()->back()->with('success', 'Rating updated successfully.');
    }

    public function destroy(UserRating $rating)
    {
        $rating->delete();
        return redirect()->back()->with('success', 'Rating deleted successfully.');
    }

    public function acceptRating(UserRating $rating)
    {
        $rating->update(['status' => 'active']);
        return redirect()->back()->with('success', 'Rating accepted.');
    }
}
