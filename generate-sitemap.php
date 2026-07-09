<?php
/**
 * Sitemap generator — run via: php artisan tinker --execute="require 'generate-sitemap.php';"
 * Or access directly at: php generate-sitemap.php
 */

// Bootstrap Laravel
chdir(__DIR__);
require_once __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Article;
use App\Models\GalleryProject;
use App\Models\Service;
use Carbon\Carbon;

// Production URL — ganti saat deploy ke hosting
$appUrl = rtrim(env('PRODUCTION_URL', 'https://www.hoistcranelift.com'), '/');

$urls = [];

// Static pages
$staticPages = [
    ['loc' => $appUrl.'/',           'priority' => '1.0', 'changefreq' => 'weekly'],
    ['loc' => $appUrl.'/about',      'priority' => '0.8', 'changefreq' => 'monthly'],
    ['loc' => $appUrl.'/services',   'priority' => '0.9', 'changefreq' => 'monthly'],
    ['loc' => $appUrl.'/gallery',    'priority' => '0.8', 'changefreq' => 'weekly'],
    ['loc' => $appUrl.'/articles',   'priority' => '0.8', 'changefreq' => 'daily'],
    ['loc' => $appUrl.'/contact',    'priority' => '0.7', 'changefreq' => 'monthly'],
];

// Articles
$articles = Article::published()->get(['slug','updated_at']);
$articleUrls = $articles->map(fn($a) => [
    'loc'        => $appUrl.'/articles/'.$a->slug,
    'lastmod'    => $a->updated_at->toDateString(),
    'priority'   => '0.8',
    'changefreq' => 'monthly',
])->toArray();

// Gallery
$gallery = GalleryProject::where('is_published', true)->get(['slug','updated_at']);
$galleryUrls = $gallery->filter(fn($g) => $g->slug)->map(fn($g) => [
    'loc'        => $appUrl.'/gallery/'.$g->slug,
    'lastmod'    => $g->updated_at->toDateString(),
    'priority'   => '0.7',
    'changefreq' => 'monthly',
])->toArray();

// Services
$services = Service::where('is_active', true)->get(['slug','updated_at']);
$serviceUrls = $services->map(fn($s) => [
    'loc'        => $appUrl.'/services/'.$s->slug,
    'lastmod'    => $s->updated_at->toDateString(),
    'priority'   => '0.85',
    'changefreq' => 'monthly',
])->toArray();

$allUrls = array_merge($staticPages, $serviceUrls, $galleryUrls, $articleUrls);

// Build XML
$xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"'."\n";
$xml .= '        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">'."\n";

$today = Carbon::now()->toDateString();

foreach ($allUrls as $url) {
    $xml .= "  <url>\n";
    $xml .= "    <loc>".htmlspecialchars($url['loc'])."</loc>\n";
    $xml .= "    <lastmod>".($url['lastmod'] ?? $today)."</lastmod>\n";
    $xml .= "    <changefreq>".($url['changefreq'] ?? 'monthly')."</changefreq>\n";
    $xml .= "    <priority>".($url['priority'] ?? '0.7')."</priority>\n";
    $xml .= "  </url>\n";
}

$xml .= '</urlset>';

file_put_contents(__DIR__.'/public/sitemap.xml', $xml);
echo "Sitemap generated: ".count($allUrls)." URLs\n";
