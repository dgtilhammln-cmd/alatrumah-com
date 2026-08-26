<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Service;
use App\Models\Article;
use Illuminate\Support\Str;

echo "Mulai mengganti 'Cyclevent' menjadi 'Alatrumah.com'...\n\n";

// Update Services
$services = Service::all();
$serviceUpdated = 0;
foreach ($services as $service) {
    $changed = false;
    if (stripos($service->meta_title, 'Cyclevent') !== false) {
        $service->meta_title = str_ireplace('Cyclevent', 'Alatrumah.com', $service->meta_title);
        $changed = true;
    }
    if (stripos($service->meta_desc, 'Cyclevent') !== false) {
        $service->meta_desc = str_ireplace('Cyclevent', 'Alatrumah.com', $service->meta_desc);
        $changed = true;
    }
    if (stripos($service->meta_keywords, 'Cyclevent') !== false) {
        $service->meta_keywords = str_ireplace('Cyclevent', 'Alatrumah.com', $service->meta_keywords);
        $changed = true;
    }
    
    // Also check name and description just in case
    if (stripos($service->name, 'Cyclevent') !== false) {
        $service->name = str_ireplace('Cyclevent', 'Alatrumah.com', $service->name);
        $changed = true;
    }
    if (stripos($service->short_desc, 'Cyclevent') !== false) {
        $service->short_desc = str_ireplace('Cyclevent', 'Alatrumah.com', $service->short_desc);
        $changed = true;
    }
    if (stripos($service->description, 'Cyclevent') !== false) {
        $service->description = str_ireplace('Cyclevent', 'Alatrumah.com', $service->description);
        $changed = true;
    }

    if ($changed) {
        $service->save();
        $serviceUpdated++;
    }
}
echo "Berhasil update $serviceUpdated services.\n";

// Update Articles
$articles = Article::all();
$articleUpdated = 0;
foreach ($articles as $article) {
    $changed = false;
    if (stripos($article->meta_title, 'Cyclevent') !== false) {
        $article->meta_title = str_ireplace('Cyclevent', 'Alatrumah.com', $article->meta_title);
        $changed = true;
    }
    if (stripos($article->meta_desc, 'Cyclevent') !== false) {
        $article->meta_desc = str_ireplace('Cyclevent', 'Alatrumah.com', $article->meta_desc);
        $changed = true;
    }
    if (stripos($article->meta_keywords, 'Cyclevent') !== false) {
        $article->meta_keywords = str_ireplace('Cyclevent', 'Alatrumah.com', $article->meta_keywords);
        $changed = true;
    }
    
    if (stripos($article->title, 'Cyclevent') !== false) {
        $article->title = str_ireplace('Cyclevent', 'Alatrumah.com', $article->title);
        $changed = true;
    }
    if (stripos($article->content, 'Cyclevent') !== false) {
        $article->content = str_ireplace('Cyclevent', 'Alatrumah.com', $article->content);
        $changed = true;
    }

    if ($changed) {
        $article->save();
        $articleUpdated++;
    }
}
echo "Berhasil update $articleUpdated articles.\n";

echo "\nSelesai!";
