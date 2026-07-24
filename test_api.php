<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$key = 'flHirqhga122b8bcfa5daa1ekEib4jrW';

// Test RajaOngkir Endpoint
$key = 'f1Hirqhga122b8bcfa5daa1ekEib4jrW';

$res1 = Illuminate\Support\Facades\Http::withoutVerifying()
    ->withHeaders(['key' => $key])
    ->get('https://rajaongkir.komerce.id/api/v1/destination/city');
$data = $res1->json('data');
foreach($data as $c) {
    if(stripos($c['name'], 'surabaya') !== false) {
        echo "Found: " . print_r($c, true);
    }
}
