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

    public function RegisterRequest(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'gender' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|min:8|confirmed',
            'address' => 'required',
            'department' => 'required',
            'grade_level' => 'required',
            'program' => 'nullable',
        ]);

        $customer = \App\Models\Customers::create([
            'fullname' => $request->fullname,
            'gender' => $request->gender,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'address' => $request->address,
            'department' => $request->department,
            'grade_year' => $request->grade_level,
            'program' => $request->program,
            'is_verified' => false,
        ]);

        $verificationUrl = route('auth.verify.email', ['email' => $customer->email, 'token' => sha1($customer->email)]);
        
        \Illuminate\Support\Facades\Mail::to($customer->email)->send(new \App\Mail\VerifyEmailMail($verificationUrl, $customer->fullname));

        return redirect()->route('auth.login.page')->with('success', 'Registration successful. Please check your email to verify your account.');
    }

    public function VerifyEmail($email, $token)
    {
        if (sha1($email) !== $token) {
            return redirect()->route('auth.login.page')->with('error', 'Invalid verification link.');
        }

        $customer = \App\Models\Customers::where('email', $email)->first();

        if (!$customer) {
            return redirect()->route('auth.login.page')->with('error', 'User not found.');
        }

        if ($customer->is_verified) {
            return redirect()->route('auth.login.page')->with('info', 'Email already verified. Please login.');
        }

        $customer->is_verified = true;
        $customer->save();

        return redirect()->route('auth.login.page')->with('success', 'Email verified successfully! You can now login.');
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

        // Check if Admin
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard.page')->with('success', 'Successfully login');
        }

        // Check if Customer
        if (Auth::guard('customer')->attempt($credentials)) {
            $user = Auth::guard('customer')->user();
            if (!$user->is_verified) {
                Auth::guard('customer')->logout();
                return redirect()->back()->withInput($request->only('email'))->with('error', 'Please verify your email address before logging in.');
            }
            return redirect()->route('customer.dashboard.page')->with('success', 'Welcome back!');
        }

        return redirect()->back()->withInput($request->only('email'))->with('error', 'Invalid credentials');
    }

    public function Logout()
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('customer')->check()) {
            Auth::guard('customer')->logout();
        }
        
        return redirect()->route('auth.login.page')->with('success', 'Successfully logout');
    }
}
