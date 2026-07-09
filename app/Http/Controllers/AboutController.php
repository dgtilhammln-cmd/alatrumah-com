<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\Client;

class AboutController extends Controller
{
    public function index()
    {
        $settings     = Setting::getAllAsArray();
        $testimonials = Testimonial::active()->ordered()->get()->unique('name');
        $clients      = Client::active()->ordered()->get();
        $wa           = \App\Models\WaSetting::primary();

        $seo = [
            'title'       => $settings['meta_title_about'] ?? 'Tentang Kami | Cyclevent - Spesialis Turbine Ventilator',
            'description' => $settings['meta_desc_about'] ?? 'Profil Cyclevent, spesialis Turbine Ventilator Non-Electric berdiri sejak 2013. Melayani ribuan pelanggan industri dan rumah tangga di seluruh Indonesia.',
            'keywords'    => $settings['meta_keywords_about'] ?? 'profil cyclevent, tentang cyclevent, spesialis turbine ventilator, ventilator atap pabrik',
            'og_image'    => !empty($settings['og_image_default']) ? asset('storage/'.$settings['og_image_default']) : (!empty($settings['logo']) ? asset('storage/'.$settings['logo']) : asset('images/og-default.jpg')),
            'canonical'   => route_locale('about'),
        ];

        $keunggulan = [
            ['icon' => 'star', 'title' => 'Produk Berkualitas', 'desc' => 'Semua produk dari bahan zincalume dan stainless steel anti karat'],
            ['icon' => 'shield', 'title' => 'Garansi 15 Tahun', 'desc' => 'Layanan purna jual & garansi resmi penggantian parts'],
            ['icon' => 'tag', 'title' => 'Tanpa Listrik', 'desc' => 'Beroperasi otomatis menggunakan tenaga angin tanpa biaya listrik'],
            ['icon' => 'map', 'title' => 'Jangkauan Nasional', 'desc' => 'Melayani pengiriman & instalasi ke seluruh Indonesia'],
            ['icon' => 'clock', 'title' => 'Tepat Waktu', 'desc' => 'Komitmen jadwal pengiriman dan pemasangan sesuai target'],
            ['icon' => 'hard-hat', 'title' => 'Konstruksi USA', 'desc' => 'Desain mengikuti standar USA tahan cuaca ekstrem'],
        ];

        $legalitas = [
            ['label' => 'Akte Notaris', 'value' => $settings['akte'] ?? 'No. 47/1093/CV/VIII/2013'],
            ['label' => 'NPWP', 'value' => $settings['npwp'] ?? '31.817.130.3-603.000'],
            ['label' => 'NIB', 'value' => $settings['nib'] ?? '9120105110524'],
        ];

        return view('about.index', compact('settings', 'testimonials', 'clients', 'seo', 'keunggulan', 'legalitas', 'wa'));
    }
}
