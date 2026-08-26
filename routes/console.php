<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Service;
use App\Models\Article;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('app:replace-cyclevent', function () {
    $this->info("Memulai proses replace kata 'cyclevent' menjadi 'alatrumah' di tabel services (produk)...");
    
    $services = Service::all();
    $countServices = 0;
    foreach ($services as $s) {
        $changed = false;
        if (stripos($s->meta_title, 'cyclevent') !== false) {
            $s->meta_title = str_ireplace('cyclevent', 'alatrumah', $s->meta_title);
            $changed = true;
        }
        if (stripos($s->meta_desc, 'cyclevent') !== false) {
            $s->meta_desc = str_ireplace('cyclevent', 'alatrumah', $s->meta_desc);
            $changed = true;
        }
        if (stripos($s->meta_keywords, 'cyclevent') !== false) {
            $s->meta_keywords = str_ireplace('cyclevent', 'alatrumah', $s->meta_keywords);
            $changed = true;
        }
        if ($changed) {
            $s->save();
            $countServices++;
        }
    }
    $this->info("Berhasil mengubah $countServices data services (produk).");

    $this->info("Memulai proses replace di tabel articles (blog)...");
    $articles = Article::all();
    $countArticles = 0;
    foreach ($articles as $a) {
        $changed = false;
        if (stripos($a->meta_title, 'cyclevent') !== false) {
            $a->meta_title = str_ireplace('cyclevent', 'alatrumah', $a->meta_title);
            $changed = true;
        }
        if (stripos($a->meta_description, 'cyclevent') !== false) {
            $a->meta_description = str_ireplace('cyclevent', 'alatrumah', $a->meta_description);
            $changed = true;
        }
        if ($changed) {
            $a->save();
            $countArticles++;
        }
    }
    $this->info("Berhasil mengubah $countArticles data articles (blog).");
    $this->info("Selesai!");
})->purpose('Ganti semua kata cyclevent menjadi alatrumah');
