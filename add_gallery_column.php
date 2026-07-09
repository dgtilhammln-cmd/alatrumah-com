<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

echo "Adding gallery column to services table...\n";

if (!Schema::hasColumn('services', 'gallery')) {
    Schema::table('services', function (Blueprint $table) {
        $table->json('gallery')->nullable()->after('image');
    });
    echo "Column 'gallery' added successfully.\n";
} else {
    echo "Column 'gallery' already exists.\n";
}
