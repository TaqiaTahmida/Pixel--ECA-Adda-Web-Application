<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    /**
     * Show admin login page
     */
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }


    /**
     * Step 1: Admin enters email → OTP is sent
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin) {
            return back()->withErrors(['email' => 'Admin not found']);
        }

        // Generate OTP
        $otp = rand(100000, 999999);

        // Save OTP to database
        $admin->otp_code = $otp;
        $admin->otp_expires_at = Carbon::now()->addMinutes(5);
        $admin->save();

        // Send OTP
        Mail::to($admin->email)->send(new OtpMail($otp));

        // Store email temporarily for OTP page
        session(['admin_email' => $admin->email]);

        return redirect()->route('admin.login.otp');
    }


    /**
     * Show OTP verification page
     */
    public function showOtpForm()
    {
        // If no email stored, go back to login
        if (!session('admin_email')) {
            return redirect()->route('admin.login');
        }

        return view('auth.admin-login-otp');
    }


    /**
     * Step 2: Verify OTP
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric'
        ]);

        $email = session('admin_email');

        $admin = Admin::where('email', $email)->first();

        if (!$admin) {
            return back()->withErrors(['otp' => 'Admin not found']);
        }

        // Check OTP validity
        if (
            $admin->otp_code !== $request->otp ||
            Carbon::now()->greaterThan($admin->otp_expires_at)
        ) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP']);
        }

        // Clear OTP after success
        $admin->otp_code = null;
        $admin->otp_expires_at = null;
        $admin->save();

        // Login as admin
        Auth::guard('admin')->login($admin);

        return redirect('/admin/dashboard');
    }
}
?>