<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Enforce HTTPS on Vercel or in production so forms submit securely without browser security warnings
        if (config('app.env') === 'production' || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') || (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') || (request() && str_contains(request()->getHost(), 'vercel.app'))) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Auto-migrate serverless database on Vercel if needed
        if (!file_exists('/tmp/.migrated_v2')) {
            @touch('/tmp/.migrated_v2');
            try {
                \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Auto-migration error: ' . $e->getMessage());
            }
        }
    }
}
