<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Drop old foreign key constraint pointing to product_categories
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign(['product_category_id']);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Restore foreign key constraint
            if (DB::getDriverName() !== 'sqlite') {
                $table->foreign('product_category_id')->references('id')->on('product_categories')->nullOnDelete();
            }
        });
    }
};
