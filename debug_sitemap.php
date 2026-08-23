<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

try {
    $services = App\Models\Service::active()->ordered()->get(['id','slug','name','image','updated_at']);
    echo "services ok: " . $services->count() . "\n";
    
    $articles = App\Models\Article::published()->latest()->get(['slug','title','image','updated_at']);
    echo "articles ok: " . $articles->count() . "\n";
    
    $authors = App\Models\Author::whereNotNull('slug')->get(['slug','name','updated_at']);
    echo "authors ok: " . $authors->count() . "\n";
    
    $content = view('sitemap', ['urls' => [
        ['url' => url('/'), 'priority' => '1.0', 'changefreq' => 'weekly', 'lastmod' => date('Y-m-d'), 'images' => []]
    ]])->render();
    
    echo "view render ok, length: " . strlen($content) . "\n";
    echo "ALL OK!\n";
} catch (Throwable $e) {
    echo get_class($e) . ": " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
