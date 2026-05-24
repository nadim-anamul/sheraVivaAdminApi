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
        Schema::create('session_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mock_session_id')->constrained('mock_sessions')->cascadeOnDelete();
            $table->integer('score');
            $table->integer('filler_words_count')->default(0);
            $table->text('feedback')->nullable();
            $table->text('recommendations')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_evaluations');
    }
};
