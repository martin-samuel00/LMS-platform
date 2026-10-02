<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Auth\Events\Registered;

class ProfileController extends Controller
{
    // Show profile & settings view
    public function show()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    // Update basic information (name, username, avatar, email, phone)
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'alpha_dash', 'min:3', 'max:30', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:2048'],
        ]);

        if ($request->hasFile('avatar')) {
            // Delete old avatar if custom
            if ($user->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->avatar)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        if ($request->filled('username')) {
            $user->username = strtolower(trim($request->username));
        }

        $emailChanged = $user->email !== $request->email;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($emailChanged) {
            $user->email_verified_at = null;
        }

        $user->save();

        if ($emailChanged) {
            try {
                event(new Registered($user));
            } catch (\Throwable $e) {}
            return redirect()->route('verification.notice')->with('success', 'Profile updated! A new email verification link has been sent to your new email.');
        }

        return back()->with('success', 'Profile and picture updated successfully!');
    }

    // Change password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password updated successfully!');
    }
}
