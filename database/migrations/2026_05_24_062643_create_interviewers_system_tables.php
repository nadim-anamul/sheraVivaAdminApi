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
        // 1. Drop old tables if they exist
        Schema::dropIfExists('live_viva_sessions');
        Schema::dropIfExists('examiners');

        // 2. Create interviewers table
        Schema::create('interviewers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('designation')->nullable();
            $table->text('bio')->nullable();
            $table->integer('base_price')->default(0); // BDT Price
            $table->string('avatar_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. Create availability_blocks table
        Schema::create('availability_blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('interviewer_id')->constrained('interviewers')->onDelete('cascade');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('slot_duration_minutes')->default(20);
            $table->timestamps();
        });

        // 4. Create slots table
        Schema::create('slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('availability_block_id')->constrained('availability_blocks')->onDelete('cascade');
            $table->foreignId('interviewer_id')->constrained('interviewers')->onDelete('cascade');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', ['available', 'temporary_locked', 'booked'])->default('available');
            $table->dateTime('locked_until')->nullable();
            $table->timestamps();
        });

        // 5. Create bookings table
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('slot_id')->constrained('slots')->onDelete('cascade');
            $table->foreignId('candidate_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('interviewer_id')->constrained('interviewers')->onDelete('cascade');
            $table->decimal('amount_paid', 8, 2)->default(0.00);
            $table->enum('payment_status', ['pending', 'success', 'failed'])->default('pending');
            $table->string('payment_trx_id')->nullable();
            $table->string('livekit_room_name');
            $table->integer('grade_score')->nullable();
            $table->text('feedback_remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('slots');
        Schema::dropIfExists('availability_blocks');
        Schema::dropIfExists('interviewers');
    }
};
