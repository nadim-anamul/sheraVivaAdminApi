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
        Schema::create('exam_knowledge_banks', function (Blueprint $table) {
            $table->id();
            $table->string('exam_type')->index();
            $table->string('subject_category')->default('General')->index();
            $table->string('title');
            $table->json('top_questions')->nullable();
            $table->json('core_topics')->nullable();
            $table->text('chairman_style')->nullable();
            $table->integer('source_items_count')->default(0);
            $table->timestamp('last_synthesized_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_knowledge_banks');
    }
};
