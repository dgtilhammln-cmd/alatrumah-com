<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Service;
use App\Models\Article;

class ReplaceCyclevent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:replace-cyclevent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ganti semua kata cyclevent menjadi alatrumah di database (meta title, desc, dll)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
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
    }
}
