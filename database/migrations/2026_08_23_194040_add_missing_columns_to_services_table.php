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
        Schema::table('services', function (Blueprint $table) {
            if (!Schema::hasColumn('services', 'gallery')) {
                $table->json('gallery')->nullable()->after('image');
            }
            if (!Schema::hasColumn('services', 'specifications')) {
                $table->json('specifications')->nullable()->after('gallery');
            }
            if (!Schema::hasColumn('services', 'faqs')) {
                $table->json('faqs')->nullable()->after('specifications');
            }
            if (!Schema::hasColumn('services', 'brochure')) {
                $table->string('brochure')->nullable()->after('faqs');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['gallery', 'specifications', 'faqs', 'brochure']);
        });
    }
};
