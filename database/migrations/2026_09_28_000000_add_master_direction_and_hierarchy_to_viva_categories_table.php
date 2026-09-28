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
        Schema::table('viva_categories', function (Blueprint $table) {
            if (!Schema::hasColumn('viva_categories', 'parent_id')) {
                $table->foreignId('parent_id')->nullable()->after('id')->constrained('viva_categories')->nullOnDelete();
            }
            if (!Schema::hasColumn('viva_categories', 'group_type')) {
                $table->string('group_type')->default('major')->after('slug'); // 'major' or 'subcategory'
            }
            if (!Schema::hasColumn('viva_categories', 'master_direction')) {
                $table->text('master_direction')->nullable()->after('subtitle');
            }
            if (!Schema::hasColumn('viva_categories', 'description')) {
                $table->text('description')->nullable()->after('master_direction');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('viva_categories', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['parent_id', 'group_type', 'master_direction', 'description']);
        });
    }
};
