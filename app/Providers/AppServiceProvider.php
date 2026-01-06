<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Laravel\Fortify\Contracts\LoginResponse;
use App\Actions\Fortify\LoginResponse as CustomLoginResponse;
use App\Models\AdminMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind Fortify's LoginResponse to your custom implementation
        $this->app->singleton(LoginResponse::class, CustomLoginResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['components.navbar', 'components.dashboard-navbar'], function ($view) {
            $unreadAdminMessages = 0;
            $user = Auth::user();

            if ($user) {
                $unreadAdminMessages = AdminMessage::where('user_id', $user->id)
                    ->whereNull('read_at')
                    ->count();
            }

            $view->with('unreadAdminMessages', $unreadAdminMessages);
        });
    }
}
