<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function RegisterPage()
    {
        return view('auth.register');
    }

    public function LoginPage()
    {
        return view('auth.login');
    }

    public function LoginRequest(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard.page')->with('success', 'Successfully login');
        }
        return redirect()->back()->withInput($request->only('email'))->with('error', 'Invalid credentials');
    }

    public function Logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('auth.login.page')->with('success', 'Successfully logout');
    }
}
