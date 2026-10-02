<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Admins can view both; if user is strictly a teacher without being an admin, redirect to teacher portal
        if ($user->isAdmin() || $user->role === 'student') {
            return $next($request);
        }

        return redirect()->route('teachers.index')
            ->with('info', 'Redirected to your Instructor Portal.');
    }
}
