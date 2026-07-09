<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Setting;

$data = [
    'meta_title_home' => 'Cyclevent — Turbine Ventilator Non-Electric #1 Indonesia',
    'meta_desc_home' => 'Produsen turbine ventilator non-electric terpercaya sejak 2007. Garansi 15 tahun tidak berkarat. 5 tipe: CV-45, CV-60, CV-75, CV-90, CV-105. Gratis konsultasi: 0812-9656-5757.',
    'meta_keywords_home' => 'turbine ventilator, ventilator atap, cyclevent, roof ventilator, ventilator non electric, kipas angin atap, vent turbine, ventilasi pabrik, ventilasi gudang',
    
    'meta_title_about' => 'Tentang Cyclevent | Pionir Turbine Ventilator di Indonesia',
    'meta_desc_about' => 'Kenali Cyclevent lebih dekat. Berpengalaman lebih dari 10 tahun sebagai produsen dan aplikator turbine ventilator roof vent terbaik bergaransi 15 tahun.',
    'meta_keywords_about' => 'profil cyclevent, pabrik turbine ventilator, distributor ventilator atap, produsen roof ventilator',
    
    'meta_title_services' => 'Daftar Produk Turbine Ventilator Cyclevent | Anti Karat & Bergaransi',
    'meta_desc_services' => 'Temukan berbagai pilihan tipe Turbine Ventilator dari Cyclevent. Cocok untuk pabrik, gudang, restoran, dan rumah. Sirkulasi udara 24 jam tanpa listrik.',
    'meta_keywords_services' => 'produk cyclevent, harga turbine ventilator, jual ventilator atap, tipe roof ventilator, spesifikasi turbine ventilator',
    
    'meta_title_gallery' => 'Galeri Instalasi Turbine Ventilator | Proyek Cyclevent',
    'meta_desc_gallery' => 'Lihat dokumentasi foto dan video hasil pemasangan turbine ventilator Cyclevent di berbagai sektor industri, gudang, dan perumahan di seluruh Indonesia.',
    'meta_keywords_gallery' => 'galeri cyclevent, proyek turbine ventilator, pemasangan ventilator atap, foto instalasi roof ventilator',
    
    'meta_title_articles' => 'Artikel & Tips Sistem Sirkulasi Udara | Blog Cyclevent',
    'meta_desc_articles' => 'Kumpulan artikel informatif tentang sistem ventilasi industri, cara memilih turbine ventilator yang tepat, dan tips menjaga sirkulasi udara bangunan.',
    'meta_keywords_articles' => 'artikel ventilasi, tips sirkulasi udara, manfaat turbine ventilator, blog cyclevent, cara pasang ventilator atap',
    
    'meta_title_contact' => 'Hubungi Cyclevent | Konsultasi Pemasangan Turbine Ventilator',
    'meta_desc_contact' => 'Punya kebutuhan sistem ventilasi pabrik atau rumah? Hubungi Cyclevent sekarang untuk konsultasi gratis, penawaran harga, dan jadwal pemasangan.',
    'meta_keywords_contact' => 'kontak cyclevent, hubungi cyclevent, alamat pabrik ventilator, no wa cyclevent, konsultasi ventilasi',
    
    'footer_desc' => 'Cyclevent adalah produsen dan aplikator Turbine Ventilator terkemuka di Indonesia. Kami menyediakan solusi sistem sirkulasi udara terbaik tanpa biaya operasional.',
    'copyright' => '© 2026 PT. Hiranatha Makmur Sukses. All rights reserved.'
];

foreach ($data as $key => $val) {
    Setting::set($key, $val, 'text');
}

echo "SEO Settings Updated Successfully.\n";
