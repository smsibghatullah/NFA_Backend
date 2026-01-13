<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth as LaravelAuth;

class AuthController extends Controller
{
    // Registration page
    public function registerView() {
        if (Auth::count() > 0) {
            return redirect('/login')->with('info', 'Registration disabled. Please login.');
        }
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request) {
        if (Auth::count() > 0) {
            return redirect('/login')->with('info', 'Registration disabled. Please login.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:auth,email',
            'password' => 'required|min:6|confirmed',
        ]);

        Auth::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'Registration successful. Please login.');
    }

    // Login page
    public function loginView() {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = Auth::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            LaravelAuth::guard('custom')->login($user);
            return redirect('/dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    // Dashboard
    public function dashboard() {
        if (!LaravelAuth::guard('custom')->check()) {
            return redirect('/login');
        }

        return view('Dashboard.home', [
            'user' => LaravelAuth::guard('custom')->user()
        ]);
    }

    // Logout
    public function logout() {
        LaravelAuth::guard('custom')->logout();
        return redirect('/login');
    }
}
