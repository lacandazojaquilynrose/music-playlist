<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Requirement 1: Show Registration Form
    public function showRegister()
    {
        return view('auth.register');
    }

    // Requirement 1: Handle Registration Request
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Redirect with toast notification
        return redirect()->route('login')->with('toast_success', 'Account registered successfully! Please log in.');
    }

    // Requirement 2: Show Login Form
    public function showLogin()
    {
        return view('auth.login');
    }

    // Requirement 2: Handle Login Request
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard')->with('toast_success', 'Welcome back, ' . Auth::user()->name . '!');
        }

        // Return error validation message if credentials fail
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Secure Session Logout Destructor
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('toast_success', 'Logged out safely.');
    }
}