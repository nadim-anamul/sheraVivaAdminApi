<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('google_id')->nullable()->index()->after('id');
            $table->string('avatar')->nullable()->after('email');
            $table->integer('ai_viva_credits')->default(0)->after('avatar');
            $table->string('role')->default('candidate')->after('ai_viva_credits');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['google_id', 'avatar', 'ai_viva_credits', 'role']);
        });
    }
};
