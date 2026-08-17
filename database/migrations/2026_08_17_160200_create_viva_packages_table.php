<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('viva_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->default('ai_mock'); // ai_mock, live_human
            $table->integer('credits')->default(10);
            $table->decimal('price_bdt', 10, 2)->default(100.00);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('viva_packages');
    }
};
