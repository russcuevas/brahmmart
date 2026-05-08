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
            if ($request->expectsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Please login first to add items to cart.'], 401);
            }
            return redirect()->route('auth.login.page')->with('error', 'Please login to access this page.');
        }

        $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();
        if (!$user->is_verified) {
            \Illuminate\Support\Facades\Auth::guard('customer')->logout();
            if ($request->expectsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Please verify your email address.'], 401);
            }
            return redirect()->route('auth.login.page')->with('error', 'Please verify your email address.');
        }

        return $next($request);
    }
}
