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
            'username' => ['required', 'string', 'alpha_dash', 'min:3', 'max:30', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:student,teacher'],
        ], [
            'username.unique' => 'This username is already taken. Please choose another one.',
            'username.alpha_dash' => 'Username may only contain letters, numbers, dashes and underscores.',
            'email.unique' => 'An account with this email address already exists.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        $incomingFields['username'] = strtolower(trim($incomingFields['username']));

        // 2. Hash password and create user in database
        $incomingFields['password'] = Hash::make($incomingFields['password']);
        $user = User::create($incomingFields);

        // 3. Automatically log in newly registered user
        Auth::login($user);

        // 4. Send email verification notification
        try {
            $verifyUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(60),
                ['id' => $user->getKey(), 'hash' => sha1($user->getEmailForVerification())]
            );
            \App\Services\EmailService::sendVerification($user, $verifyUrl);
            session()->flash('direct_verify_url', $verifyUrl);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Email verification dispatch error: ' . $e->getMessage());
        }

        // 5. Redirect to email verification notice or dashboard
        return redirect()->route('dashboard')->with('success', "Welcome to Classroom Hub, @{$user->username}!");
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
        if (filter_var($loginInput, FILTER_VALIDATE_EMAIL)) {
            $fieldType = 'email';
        } elseif (User::where('username', $loginInput)->exists()) {
            $fieldType = 'username';
        } else {
            $fieldType = 'name';
        }

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
