<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\ECAController;
use App\Http\Controllers\Admin\AdminEcaController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\OneToOneController;
use App\Http\Controllers\User\CalendarController;
use App\Http\Controllers\User\EventController;

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
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'sendOtp'])->name('login.sendOtp');
Route::get('/login/otp', [LoginController::class, 'showOtpForm'])->name('login.otp');
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
| ECA ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/eca', [ECAController::class, 'index'])->name('eca.index');
Route::get('/eca/{id}', [ECAController::class, 'show'])->name('eca.show');
Route::post('/eca/{id}/join', [ECAController::class, 'join'])->middleware('auth')->name('eca.join');
Route::get('/my-ecas', [ECAController::class, 'myEcas'])->middleware('auth')->name('eca.my');

Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    // Dashboard home
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('dashboard.profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('dashboard.profile.update');
    Route::get('/subscription', [ProfileController::class, 'subscription'])->name('dashboard.subscription');
    Route::get('/security', [ProfileController::class, 'security'])->name('dashboard.security');
    Route::put('/security', [ProfileController::class, 'updatePassword'])->name('dashboard.password.update');

    // AI Advisor
    Route::get('/aidash', [AIController::class, 'index'])->name('dashboard.aidash');

    // ECAs
    Route::get('/ecas', [EcaController::class, 'index'])->name('dashboard.ecas');

    // Calendar (default tab)
    Route::get('/calendar', [CalendarController::class, 'myEvents'])->name('calendar.my-events');
    Route::get('/calendar/deadlines', [CalendarController::class, 'deadlines'])->name('calendar.deadlines');
    Route::get('/calendar/sessions', [CalendarController::class, 'sessions'])->name('calendar.sessions');

    // Events CRUD
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events/store', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    Route::get('/calendar/my-events', [EventController::class, 'index'])->name('calendar.my-events');

    // Tier 2 Session
    Route::get('/session', [SessionController::class, 'index'])->name('dashboard.session');
});

/*
|--------------------------------------------------------------------------
| ADMIN DASHBOARD + ECA MANAGEMENT
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::resource('eca', AdminEcaController::class);
});

