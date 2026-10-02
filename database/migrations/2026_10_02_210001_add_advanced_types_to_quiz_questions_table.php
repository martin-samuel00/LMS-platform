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
        Schema::table('quizzes', function (Blueprint $table) {
            if (!Schema::hasColumn('quizzes', 'duration_minutes')) {
                $table->integer('duration_minutes')->nullable()->after('pass_percentage');
            }
        });

        Schema::table('quiz_questions', function (Blueprint $table) {
            if (!Schema::hasColumn('quiz_questions', 'question_type')) {
                $table->string('question_type')->default('choose')->after('quiz_id'); // choose, true_false, complete, match, essay, scientific_term
            }
            if (!Schema::hasColumn('quiz_questions', 'time_limit_seconds')) {
                $table->integer('time_limit_seconds')->nullable()->after('question_type'); // per-question timer set by teacher
            }
            if (!Schema::hasColumn('quiz_questions', 'correct_answer_text')) {
                $table->text('correct_answer_text')->nullable()->after('correct_option'); // for complete / scientific term / essay
            }
            if (!Schema::hasColumn('quiz_questions', 'matching_pairs')) {
                $table->json('matching_pairs')->nullable()->after('correct_answer_text'); // for matching questions
            }
            if (!Schema::hasColumn('quiz_questions', 'points')) {
                $table->integer('points')->default(1)->after('matching_pairs');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            if (Schema::hasColumn('quizzes', 'duration_minutes')) {
                $table->dropColumn('duration_minutes');
            }
        });

        Schema::table('quiz_questions', function (Blueprint $table) {
            $cols = ['question_type', 'time_limit_seconds', 'correct_answer_text', 'matching_pairs', 'points'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('quiz_questions', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
