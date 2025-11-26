<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\OtpController;


/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingController::class, 'index'])->name('landing');


/*
|--------------------------------------------------------------------------
| USER AUTHENTICATION (Login + OTP)
|--------------------------------------------------------------------------
*/

// Show login form
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Send OTP
Route::post('/login', [LoginController::class, 'sendOtp'])->name('login.sendOtp');

// Show OTP input page
Route::get('/login/otp', [LoginController::class, 'showOtpForm'])->name('login.otp');

// Verify OTP
Route::post('/login/verify', [OtpController::class, 'verifyOtp'])->name('login.verify');


/*
|--------------------------------------------------------------------------
| USER REGISTRATION (Multi-step)
|--------------------------------------------------------------------------
*/

Route::get('/register/step1', [RegisterController::class, 'step1'])->name('register.step1');
Route::post('/register/step1', [RegisterController::class, 'storeStep1'])->name('register.storeStep1');

Route::get('/register/step2', [RegisterController::class, 'step2'])->name('register.step2');
Route::post('/register/step2', [RegisterController::class, 'storeStep2'])->name('register.storeStep2');

Route::get('/register/step3', [RegisterController::class, 'step3'])->name('register.step3');
Route::post('/register/step3', [RegisterController::class, 'complete'])->name('register.complete');


/*
|--------------------------------------------------------------------------
| ADMIN LOGIN + OTP
|--------------------------------------------------------------------------
*/

// Show admin login page
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])
    ->name('admin.login');

// POST: Send OTP to admin email
Route::post('/admin/login', [AdminLoginController::class, 'login'])
    ->name('admin.login.post');

// GET: Show OTP form
Route::get('/admin/login/otp', [AdminLoginController::class, 'showOtpForm'])
    ->name('admin.login.otp');

// POST: Verify OTP
Route::post('/admin/login/verify', [AdminLoginController::class, 'verifyOtp'])
    ->name('admin.login.verify');


?>
