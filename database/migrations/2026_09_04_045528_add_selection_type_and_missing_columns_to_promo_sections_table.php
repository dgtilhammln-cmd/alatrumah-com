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
        Schema::table('promo_sections', function (Blueprint $table) {
            if (!Schema::hasColumn('promo_sections', 'selection_type')) {
                $table->string('selection_type')->default('manual')->after('is_active');
            }
            if (!Schema::hasColumn('promo_sections', 'category_id')) {
                $table->unsignedBigInteger('category_id')->nullable()->after('selection_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promo_sections', function (Blueprint $table) {
            $table->dropColumn(['selection_type', 'category_id']);
        });
    }
};
