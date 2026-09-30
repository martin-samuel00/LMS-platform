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
        $existingCr = collect(Schema::getIndexes('classroom_messages'))->pluck('name');
        if (! $existingCr->contains('idx_cr_messages_class_created')) {
            Schema::table('classroom_messages', function (Blueprint $table) {
                $table->index(['classroom_id', 'created_at'], 'idx_cr_messages_class_created');
            });
        }

        $existingDm = collect(Schema::getIndexes('direct_messages'))->pluck('name');
        if (! $existingDm->contains('idx_dm_sender_recv_created')) {
            Schema::table('direct_messages', function (Blueprint $table) {
                $table->index(['sender_id', 'receiver_id', 'created_at'], 'idx_dm_sender_recv_created');
            });
        }
        if (! $existingDm->contains('idx_dm_recv_is_read')) {
            Schema::table('direct_messages', function (Blueprint $table) {
                $table->index(['receiver_id', 'is_read'], 'idx_dm_recv_is_read');
            });
        }

        $existingNotif = collect(Schema::getIndexes('app_notifications'))->pluck('name');
        if (! $existingNotif->contains('idx_notifications_user_is_read')) {
            Schema::table('app_notifications', function (Blueprint $table) {
                $table->index(['user_id', 'is_read'], 'idx_notifications_user_is_read');
            });
        }

        $existingQuiz = collect(Schema::getIndexes('quiz_submissions'))->pluck('name');
        if (! $existingQuiz->contains('idx_quiz_sub_quiz_user')) {
            Schema::table('quiz_submissions', function (Blueprint $table) {
                $table->index(['quiz_id', 'user_id'], 'idx_quiz_sub_quiz_user');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classroom_messages', function (Blueprint $table) {
            $table->dropIndex('idx_cr_messages_class_created');
        });

        Schema::table('direct_messages', function (Blueprint $table) {
            $table->dropIndex('idx_dm_sender_recv_created');
            $table->dropIndex('idx_dm_recv_is_read');
        });

        Schema::table('app_notifications', function (Blueprint $table) {
            $table->dropIndex('idx_notifications_user_is_read');
        });

        Schema::table('quiz_submissions', function (Blueprint $table) {
            $table->dropIndex('idx_quiz_sub_quiz_user');
        });
    }
};
