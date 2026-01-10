<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticatedCustom
{
    /**
     * Handle an incoming request.
     * Optional $guard parameter to allow different guards.
     */
    public function handle(Request $request, Closure $next, $guard = 'custom')
    {
        // Check if user is logged in with the specified guard
        if (Auth::guard($guard)->check()) {
            return redirect('/dashboard'); // already logged in → redirect
        }

        return $next($request);
    }
}
