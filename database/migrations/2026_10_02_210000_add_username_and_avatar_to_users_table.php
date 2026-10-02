<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->nullable()->unique()->after('name');
            }
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('email');
            }
        });

        // Auto-generate usernames for existing users if any exist without one
        try {
            $users = \Illuminate\Support\Facades\DB::table('users')->whereNull('username')->get();
            foreach ($users as $u) {
                $base = \Illuminate\Support\Str::slug($u->name, '');
                if (empty($base)) $base = 'user';
                $candidate = $base . $u->id;
                \Illuminate\Support\Facades\DB::table('users')->where('id', $u->id)->update([
                    'username' => $candidate
                ]);
            }
        } catch (\Throwable $e) {}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'username')) {
                $table->dropColumn('username');
            }
            if (Schema::hasColumn('users', 'avatar')) {
                $table->dropColumn('avatar');
            }
        });
    }
};
