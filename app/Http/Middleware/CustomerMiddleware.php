<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!\Illuminate\Support\Facades\Auth::guard('customer')->check()) {
            return redirect()->route('auth.login.page')->with('error', 'Please login to access this page.');
        }

        $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();
        if (!$user->is_verified) {
            \Illuminate\Support\Facades\Auth::guard('customer')->logout();
            return redirect()->route('auth.login.page')->with('error', 'Please verify your email address.');
        }

        return $next($request);
    }
}
