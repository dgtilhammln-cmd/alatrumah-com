<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

if (!Schema::hasColumn('clients', 'logo')) {
    Schema::table('clients', function (Blueprint $table) {
        $table->string('logo')->nullable()->after('name');
    });
    echo "Column 'logo' added successfully.\n";
} else {
    echo "Column 'logo' already exists.\n";
}
