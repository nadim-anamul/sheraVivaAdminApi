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
        Schema::create('question_banks', function (Blueprint $table) {
            $table->id();
            $table->string('item_id')->nullable()->index(); // e.g. bcs_৪৬_1, bank_1
            $table->string('exam_type')->default('BCS')->index(); // BCS, Bank, Primary, etc.
            $table->string('title');
            $table->string('edition')->nullable();
            $table->string('year')->nullable();
            $table->string('candidate_name')->nullable();
            $table->string('subject')->nullable();
            $table->string('district')->nullable();
            $table->string('upazila')->nullable();
            $table->text('board')->nullable();
            $table->json('choices')->nullable();
            $table->string('duration')->nullable();
            $table->string('result')->nullable();
            $table->string('experience_rating')->default('Good');
            $table->text('remarks')->nullable();
            $table->json('transcript')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_banks');
    }
};
