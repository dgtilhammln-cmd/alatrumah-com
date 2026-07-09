<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Check if hero_bg_image is saved in settings
$row = DB::table('settings')->where('key', 'hero_bg_image')->first();
if ($row) {
    echo "hero_bg_image found: " . $row->value . " (type: " . $row->type . ")\n";
} else {
    echo "hero_bg_image NOT FOUND in database. Creating placeholder...\n";
    // Insert with image type so it will be treated correctly
    DB::table('settings')->insert([
        'key'        => 'hero_bg_image',
        'value'      => '',
        'type'       => 'image',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    echo "Placeholder created.\n";
}

// List all settings keys for reference
$settings = DB::table('settings')->orderBy('key')->get(['key', 'type', 'value']);
echo "\nAll settings:\n";
foreach ($settings as $s) {
    $val = strlen($s->value) > 50 ? substr($s->value, 0, 50) . '...' : $s->value;
    echo "  [{$s->type}] {$s->key} = {$val}\n";
}
