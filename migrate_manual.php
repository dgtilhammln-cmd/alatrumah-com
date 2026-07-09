<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

echo "Wiping database...\n";
Schema::dropAllTables();
Schema::dropAllViews();

echo "Running migrations manually...\n";
$dir = database_path('migrations');
$files = scandir($dir);
sort($files);

// Create migrations table just to make Laravel happy if it needs it later
Schema::create('migrations', function ($table) {
    $table->increments('id');
    $table->string('migration');
    $table->integer('batch');
});

foreach($files as $file) {
    if(str_ends_with($file, '.php')) {
        echo "Migrating: $file\n";
        $migration = require $dir.'/'.$file;
        if(is_object($migration) && method_exists($migration, 'up')) {
            $migration->up();
            DB::table('migrations')->insert([
                'migration' => str_replace('.php', '', $file),
                'batch' => 1
            ]);
        }
    }
}

echo "Migrations completed.\n";

echo "Running seeder...\n";
Artisan::call('db:seed', ['--force' => true]);
echo Artisan::output();
echo "Seeding completed.\n";
