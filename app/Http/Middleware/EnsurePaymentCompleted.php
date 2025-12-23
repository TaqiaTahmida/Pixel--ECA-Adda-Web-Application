<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsurePaymentCompleted
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->payment_status !== 'paid') {
            return redirect()->route('payment.checkout')
                ->with('error', 'Please complete payment to access dashboard.');
        }

        return $next($request);
    }
}
?>