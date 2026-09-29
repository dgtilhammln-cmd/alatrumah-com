<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel ini menyimpan kombinasi varian ala Shopee.
     * Contoh: Merah × S, Merah × M, Biru × S, Biru × M
     * Setiap kombinasi punya harga, stok, dan SKU sendiri.
     */
    public function up(): void
    {
        Schema::create('product_variant_combinations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                ->constrained('services')
                ->cascadeOnDelete();

            // Nilai varian 1 (wajib)
            $table->foreignId('option1_value_id')
                ->constrained('product_variant_values')
                ->cascadeOnDelete();

            // Nilai varian 2 (opsional — hanya jika ada 2 grup varian)
            $table->foreignId('option2_value_id')
                ->nullable()
                ->constrained('product_variant_values')
                ->cascadeOnDelete();

            // Harga final kombinasi (bukan delta, tapi harga absolut)
            $table->decimal('price', 15, 2)->default(0);

            // Stok khusus kombinasi ini
            $table->unsignedInteger('stock')->default(0);

            // SKU khusus kombinasi
            $table->string('sku')->nullable();

            // Gambar khusus per kombinasi (opsional)
            $table->string('image')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique(['product_id', 'option1_value_id', 'option2_value_id'], 'unique_combination');
            $table->index('product_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variant_combinations');
    }
};
