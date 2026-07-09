<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

if (!Schema::hasColumn('services', 'brochure')) {
    Schema::table('services', function (Blueprint $table) {
        $table->string('brochure')->nullable()->after('specifications');
    });
    echo "Column 'brochure' added to 'services' table.\n";
} else {
    echo "Column 'brochure' already exists.\n";
}
