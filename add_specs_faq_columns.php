<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

echo "Menambahkan kolom specifications dan faqs ke tabel services...\n";

if (!Schema::hasColumn('services', 'specifications')) {
    Schema::table('services', function (Blueprint $table) {
        $table->json('specifications')->nullable()->after('description');
    });
    echo "Kolom specifications berhasil ditambahkan.\n";
} else {
    echo "Kolom specifications sudah ada.\n";
}

if (!Schema::hasColumn('services', 'faqs')) {
    Schema::table('services', function (Blueprint $table) {
        $table->json('faqs')->nullable()->after('specifications');
    });
    echo "Kolom faqs berhasil ditambahkan.\n";
} else {
    echo "Kolom faqs sudah ada.\n";
}

echo "Selesai!\n";
