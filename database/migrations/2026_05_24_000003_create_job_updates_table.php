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
        Schema::create('job_updates', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['circular', 'result']);
            $table->string('title');
            $table->string('organization');
            $table->string('file_url');
            $table->string('file_size');
            $table->date('published_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_updates');
    }
};
