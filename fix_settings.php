<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Setting;

Setting::updateOrCreate(['key' => 'about_c1_title'], ['value' => 'Pengalaman']);
Setting::updateOrCreate(['key' => 'about_c1_val'], ['value' => '10+ Tahun']);

Setting::updateOrCreate(['key' => 'about_c2_title'], ['value' => 'Komitmen Kualitas']);
Setting::updateOrCreate(['key' => 'about_c2_val'], ['value' => '100%']);
Setting::updateOrCreate(['key' => 'about_c2_desc'], ['value' => 'Memberikan solusi sirkulasi udara terbaik untuk industri.']);

Setting::updateOrCreate(['key' => 'about_c3_title'], ['value' => 'Proyek Selesai']); // (unused in view but good to have)
Setting::updateOrCreate(['key' => 'about_c3_val'], ['value' => '120+']);
Setting::updateOrCreate(['key' => 'about_c3_desc'], ['value' => 'Proyek instalasi diselesaikan di seluruh Indonesia.']);

Setting::updateOrCreate(['key' => 'about_c4_title'], ['value' => 'Produk Terjual']);
Setting::updateOrCreate(['key' => 'about_c4_val'], ['value' => '10.000+']);
Setting::updateOrCreate(['key' => 'about_c4_desc'], ['value' => 'Unit ventilator terpasang di berbagai sektor industri.']);

echo "Settings updated successfully!\n";
