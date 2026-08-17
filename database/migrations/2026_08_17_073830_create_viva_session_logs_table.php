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
        Schema::create('viva_session_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('candidate_name')->default('Candidate');
            $table->string('exam_type')->index();
            $table->string('position')->nullable();
            $table->text('candidate_cv')->nullable();
            $table->integer('total_questions')->default(5);
            $table->integer('overall_score')->default(0);
            $table->string('verdict')->nullable();
            $table->json('score_breakdown')->nullable();
            $table->text('board_feedback')->nullable();
            $table->text('recommendations')->nullable();
            $table->json('transcript')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('viva_session_logs');
    }
};
