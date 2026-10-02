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
        // Auto-migrate serverless database on Vercel if needed
        if (!file_exists('/tmp/.migrated')) {
            try {
                if (!\Illuminate\Support\Facades\Schema::hasTable('classrooms')) {
                    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
                }
                @touch('/tmp/.migrated');
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Auto-migration error: ' . $e->getMessage());
            }
        }
    }
}
