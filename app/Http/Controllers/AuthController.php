<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    // Show registration form
    public function showRegister()
    {
        return view('auth.register');
    }

    // Handle user registration
    public function register(Request $request)
    {
        // 1. Validate inputs
        $incomingFields = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:student,teacher'],
        ]);

        // 2. Hash password and create user in database
        $incomingFields['password'] = Hash::make($incomingFields['password']);
        $user = User::create($incomingFields);

        // 3. Automatically log in newly registered user
        Auth::login($user);

        // 4. Send email verification notification
        event(new Registered($user));

        // 5. Redirect to email verification notice
        return redirect()->route('verification.notice')->with('success', 'Account created! A verification link has been sent to your email.');
    }

    // Show login form
    public function showLogin()
    {
        return view('auth.login');
    }

    // Handle user login
    public function login(Request $request)
    {
        // 1. Validate input
        $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $loginInput = trim($request->input('email'));
        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        $credentials = [
            $fieldType => $loginInput,
            'password' => $request->input('password'),
        ];

        // 2. Check credentials & log in
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Regenerate session ID to prevent session fixation attacks
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'))->with('success', 'Logged in successfully!');
        }

        // 3. If login fails, return back with an error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Handle user logout
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session and regenerate CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }

    // Protected dashboard view
    public function dashboard()
    {
        return view('dashboard');
    }
}
