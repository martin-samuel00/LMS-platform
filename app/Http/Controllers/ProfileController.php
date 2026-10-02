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
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:10240'],
            'avatar_data' => ['nullable', 'string'],
        ]);

        if ($request->filled('avatar_data') && str_starts_with($request->avatar_data, 'data:image')) {
            $user->avatar = $request->avatar_data;
        } elseif ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $mime = $file->getMimeType() ?: 'image/jpeg';
            $data = base64_encode(file_get_contents($file->getRealPath()));
            $user->avatar = "data:{$mime};base64,{$data}";
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

        try {
            $user->save();
        } catch (\Throwable $e) {
            // Auto-heal column if TiDB/MySQL still has avatar as VARCHAR(255)
            if (str_contains($e->getMessage(), 'Data too long') || str_contains($e->getMessage(), '1406') || str_contains(strtolower($e->getMessage()), 'avatar')) {
                try {
                    \Illuminate\Support\Facades\DB::statement('ALTER TABLE users MODIFY avatar MEDIUMTEXT NULL');
                    $user->save();
                } catch (\Throwable $alterErr) {
                    \Illuminate\Support\Facades\Log::error('Avatar column update error: ' . $alterErr->getMessage());
                    return back()->with('error', 'Could not save profile picture: ' . $alterErr->getMessage());
                }
            } else {
                \Illuminate\Support\Facades\Log::error('Profile update error: ' . $e->getMessage());
                return back()->with('error', 'Failed to update profile: ' . $e->getMessage());
            }
        }

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
