<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Service;

$faqs = [
    [
        'q' => 'Apakah Cyclevent Turbine Ventilator memerlukan listrik?',
        'a' => 'Sama sekali tidak. Cyclevent beroperasi 100% menggunakan tenaga angin dan perbedaan tekanan udara, sehingga bebas biaya listrik selamanya.'
    ],
    [
        'q' => 'Berapa lama garansi yang diberikan?',
        'a' => 'Kami memberikan garansi resmi untuk produk Cyclevent hingga 5 tahun, mencakup cacat pabrik dan performa putaran mesin.'
    ],
    [
        'q' => 'Apakah materialnya tahan karat?',
        'a' => 'Ya, Cyclevent terbuat dari material Alumunium atau Stainless Steel berkualitas tinggi yang tahan terhadap cuaca ekstrem dan karat.'
    ]
];

$specs = [
    ['key' => 'Material', 'value' => 'Alumunium / Stainless Steel'],
    ['key' => 'Diameter (Leher)', 'value' => 'Varies (e.g. 45cm, 60cm, 90cm)'],
    ['key' => 'Kapasitas Hisap', 'value' => 'Mulai dari 45 m3/menit'],
    ['key' => 'Bearing System', 'value' => 'Double Bearing (High Durability)'],
    ['key' => 'Tingkat Kebisingan', 'value' => 'Sangat Rendah (Silent)'],
    ['key' => 'Perawatan', 'value' => 'Bebas Perawatan (Maintenance Free)'],
];

$services = Service::all();
foreach ($services as $service) {
    if (empty($service->faqs)) {
        $service->faqs = $faqs;
    }
    if (empty($service->specifications)) {
        $service->specifications = $specs;
    }
    $service->save();
}

echo "Products updated successfully!\n";
