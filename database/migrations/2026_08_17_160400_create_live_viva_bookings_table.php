<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('live_viva_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('interviewer_id')->nullable()->constrained('interviewers')->nullOnDelete();
            $table->foreignId('payment_transaction_id')->nullable()->constrained('payment_transactions')->nullOnDelete();
            $table->string('exam_type')->default('BCS');
            $table->string('target_position')->nullable();
            $table->dateTime('scheduled_at')->nullable();
            $table->string('google_meet_url')->nullable();
            $table->string('recording_url')->nullable();
            $table->string('status')->default('pending_payment'); // pending_payment, scheduled, completed, cancelled
            $table->integer('overall_score')->nullable();
            $table->text('board_feedback')->nullable();
            $table->text('recommendations')->nullable();
            $table->json('evaluation_scorecard')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('live_viva_bookings');
    }
};
