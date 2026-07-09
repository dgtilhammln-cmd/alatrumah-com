<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

echo "Updating database schema...\n";

if (!Schema::hasColumn('clients', 'alt_text')) {
    Schema::table('clients', function (Blueprint $table) {
        $table->string('alt_text')->nullable()->after('logo');
    });
    echo "Added alt_text to clients table.\n";
}

if (!Schema::hasTable('hero_slides')) {
    Schema::create('hero_slides', function (Blueprint $table) {
        $table->id();
        $table->string('title')->nullable();
        $table->text('description')->nullable();
        $table->string('icon')->nullable();
        $table->string('image')->nullable();
        $table->string('button_text')->nullable();
        $table->string('button_url')->nullable();
        $table->integer('order')->default(0);
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
    echo "Created hero_slides table.\n";
} else {
    Schema::table('hero_slides', function (Blueprint $table) {
        if (!Schema::hasColumn('hero_slides', 'title')) $table->string('title')->nullable();
        if (!Schema::hasColumn('hero_slides', 'description')) $table->text('description')->nullable();
        if (!Schema::hasColumn('hero_slides', 'icon')) $table->string('icon')->nullable();
        if (!Schema::hasColumn('hero_slides', 'image')) $table->string('image')->nullable();
        if (!Schema::hasColumn('hero_slides', 'button_text')) $table->string('button_text')->nullable();
        if (!Schema::hasColumn('hero_slides', 'button_url')) $table->string('button_url')->nullable();
        if (!Schema::hasColumn('hero_slides', 'order')) $table->integer('order')->default(0);
        if (!Schema::hasColumn('hero_slides', 'is_active')) $table->boolean('is_active')->default(true);
    });
    echo "Updated hero_slides table.\n";
}

echo "Done.\n";
