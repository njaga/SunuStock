<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIfApproved
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->is_approved) {
            Auth::logout();
            return redirect()->route('login')->withErrors(['Votre compte est en attente de validation.']);
        }

        return $next($request);
    }
}
