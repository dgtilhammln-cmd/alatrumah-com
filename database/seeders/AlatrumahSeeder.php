<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class AlatrumahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Truncate Data Alatrumah.com
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // for mysql
        // But since we are using SQLite, we can just delete:
        DB::table('clients')->delete();
        DB::table('testimonials')->delete();
        DB::table('gallery_projects')->delete();
        DB::table('articles')->delete();
        DB::table('hero_slides')->delete();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Set Data Baru untuk alatrumah.com
        $settings = [
            // Identitas Utama
            'site_name'    => 'Alat Rumah',
            'domain'       => 'alatrumah.com',
            'tagline'      => 'Semua Kebutuhan Rumah, Satu Tempat',
            'short_desc'   => 'Toko online alat rumah tangga terlengkap. Menjual produk berkualitas dan menyediakan jasa pemasangan serta servis untuk kebutuhan hunian Anda.',
            'established'  => '',
            'business_type'=> 'Toko online & Jasa',

            // Kontak & Lokasi
            'contact.phone'    => '',
            'contact.whatsapp' => '',
            'contact.email'    => '',
            'contact.address'  => '',
            'contact.city'     => 'Jakarta',
            'contact.province' => 'DKI Jakarta',

            // SEO Default
            'meta_title_home' => 'Beranda | Alat Rumah - Toko Alat Rumah Tangga Online',
            'meta_desc_home'  => 'Belanja alat rumah tangga berkualitas di alatrumah.com. Produk lengkap, harga terjangkau, pengiriman ke seluruh Indonesia.',
            'meta_keywords_home' => 'alat rumah tangga, peralatan rumah, toko alat rumah online, jasa pemasangan',

            'meta_title_about' => 'Tentang Kami | Alat Rumah',
            'meta_desc_about'  => 'Profil Alat Rumah, toko online alat rumah tangga terlengkap. Melayani seluruh Indonesia.',
            'meta_keywords_about' => 'tentang alat rumah, profil toko, toko alat rumah',

            'meta_title_products' => 'Produk & Layanan | Alat Rumah',
            'meta_desc_products'  => 'Temukan berbagai produk alat rumah tangga berkualitas dan layanan jasa profesional di Alat Rumah.',
            'meta_keywords_products' => 'produk rumah tangga, jual alat rumah, layanan servis, jasa pasang',

            'meta_title_articles' => 'Artikel & Tips | Alat Rumah',
            'meta_desc_articles'  => 'Kumpulan artikel, tips, dan panduan merawat alat rumah tangga.',
            'meta_keywords_articles' => 'tips rumah tangga, artikel rumah, panduan produk',

            'meta_title_contact' => 'Hubungi Kami | Alat Rumah',
            'meta_desc_contact'  => 'Hubungi Alat Rumah untuk konsultasi produk, pemesanan, dan layanan jasa.',
            'meta_keywords_contact' => 'kontak alat rumah, hubungi toko',

            'meta_title_gallery' => 'Galeri | Alat Rumah',
            'meta_desc_gallery'  => 'Dokumentasi produk dan instalasi alat rumah tangga dari Alat Rumah.',
            'meta_keywords_gallery' => 'galeri alat rumah, instalasi',
        ];

        // Kosongkan tabel settings lama
        DB::table('settings')->delete();

        // Insert new settings
        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $this->command->info('Rebrand ke alatrumah.com berhasil diselesaikan!');
    }
}
