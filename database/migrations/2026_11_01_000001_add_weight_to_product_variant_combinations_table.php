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
        if (Schema::hasTable('product_variant_combinations')) {
            Schema::table('product_variant_combinations', function (Blueprint $table) {
                if (!Schema::hasColumn('product_variant_combinations', 'weight')) {
                    $table->unsignedInteger('weight')->nullable()->default(0)->after('stock');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('product_variant_combinations')) {
            Schema::table('product_variant_combinations', function (Blueprint $table) {
                if (Schema::hasColumn('product_variant_combinations', 'weight')) {
                    $table->dropColumn('weight');
                }
            });
        }
    }
};

