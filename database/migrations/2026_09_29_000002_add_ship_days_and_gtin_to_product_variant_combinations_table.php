<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_variant_combinations', function (Blueprint $table) {
            if (!Schema::hasColumn('product_variant_combinations', 'ship_days')) {
                $table->unsignedInteger('ship_days')->default(2)->after('stock');
            }
            if (!Schema::hasColumn('product_variant_combinations', 'gtin')) {
                $table->string('gtin')->nullable()->after('sku');
            }
        });
    }

    public function down(): void
    {
        Schema::table('product_variant_combinations', function (Blueprint $table) {
            if (Schema::hasColumn('product_variant_combinations', 'ship_days')) {
                $table->dropColumn('ship_days');
            }
            if (Schema::hasColumn('product_variant_combinations', 'gtin')) {
                $table->dropColumn('gtin');
            }
        });
    }
};
