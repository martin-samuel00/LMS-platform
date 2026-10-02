<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            DB::statement('ALTER TABLE users MODIFY avatar MEDIUMTEXT NULL');
        } catch (\Throwable $e) {
            // Fallback for sqlite or unsupported drivers
            try {
                Schema::table('users', function (Blueprint $table) {
                    $table->mediumText('avatar')->nullable()->change();
                });
            } catch (\Throwable $ex) {}
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            DB::statement('ALTER TABLE users MODIFY avatar VARCHAR(255) NULL');
        } catch (\Throwable $e) {}
    }
};
