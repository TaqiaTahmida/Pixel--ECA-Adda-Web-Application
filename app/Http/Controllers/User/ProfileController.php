<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Show the Personal Info tab.
     */
    public function edit(): View
    {
        $user = Auth::user();

        // Match registration options exactly
        $educationLevels = [
    'grade6-8'     => 'Grade 6 - 8',
    'grade9-10'    => 'Grade 9 - 10 / SSC / equivalent',
    'grade11-12'   => 'Grade 11 - 12 / HSC / equivalent',
    'gap-year'     => 'Gap Year Student',
];

        $interests = [
    'Art', 'Music & Performing Arts', 'Volunteering', 'Business & Entrepreneurship',
    'Literature & Writing', 'Technology', 'Sports & Athletics', 'Leadership & Debate',
    'Science & Research', 'Mathematics'
];

        return view('dashboard.profile.info', compact('user', 'educationLevels', 'interests'));
    }

    /**
     * Update Personal Info.
     */
    public function update(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'phone'           => 'nullable|string|min:10|max:20',
            'institution'     => 'nullable|string|max:255',
            'education_level' => 'nullable|string|max:255',
            'interests'       => 'nullable|array',
        ]);

        $user = Auth::user();
        $user->name            = $request->name;
        $user->phone           = $request->phone;
        $user->institution     = $request->institution;
        $user->education_level = $request->education_level;
        $user->interests       = $request->interests; // stored as JSON
        $user->save();

        return Redirect::route('dashboard.profile')->with('status', 'Profile updated successfully.');
    }

    /**
     * Show Subscription tab.
     */
    public function subscription(): View
    {
        $user = Auth::user();
        return view('dashboard.profile.subscription', compact('user'));
    }

    /**
     * Show Security tab.
     */
    public function security(): View
    {
        return view('dashboard.profile.security');
    }

    /**
     * Update password securely.
     */
    public function updatePassword(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'current_password'          => 'required',
            'new_password'              => 'required|min:6|confirmed',
            'new_password_confirmation' => 'required',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return Redirect::route('dashboard.security')->with('status', 'Password updated successfully.');
    }

    /**
     * Optional: Delete account.
     */
    public function destroy(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
?>