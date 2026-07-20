<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$key = 'flHirqhga122b8bcfa5daa1ekEib4jrW';

// Test RajaOngkir Endpoint
$res1 = Illuminate\Support\Facades\Http::withoutVerifying()
    ->withHeaders(['key' => $key])
    ->asForm()
    ->post('https://api.rajaongkir.com/starter/cost', [
        'origin' => 444,
        'destination' => 114,
        'weight' => 1000,
        'courier' => 'jne'
    ]);

echo "=== RajaOngkir Endpoint ===\n";
print_r($res1->json());

// Test Komerce Endpoint
$res2 = Illuminate\Support\Facades\Http::withoutVerifying()
    ->withHeaders(['x-api-key' => $key])
    ->asForm()
    ->post('https://api-sandbox.collaborator.komerce.id/v1/shipping/cost', [
        'origin' => 444,
        'destination' => 114,
        'weight' => 1000,
        'courier' => 'jne'
    ]);

echo "\n=== Komerce Endpoint ===\n";
print_r($res2->json());
