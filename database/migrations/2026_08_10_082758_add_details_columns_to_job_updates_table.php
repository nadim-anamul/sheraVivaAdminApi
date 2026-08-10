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
        Schema::table('job_updates', function (Blueprint $table) {
            $table->string('vacancies')->nullable()->after('organization');
            $table->date('application_deadline')->nullable()->after('published_date');
            $table->text('qualifications')->nullable()->after('vacancies');
            $table->text('description')->nullable()->after('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_updates', function (Blueprint $table) {
            $table->dropColumn(['vacancies', 'application_deadline', 'qualifications', 'description']);
        });
    }
};
