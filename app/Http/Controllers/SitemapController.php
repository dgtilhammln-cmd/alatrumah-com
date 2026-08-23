<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SitemapController extends Controller
{
    public function index(Request $request)
    {
        try {
            $services = \App\Models\Service::where('is_active', true)
                ->orderBy('order')
                ->get(['id', 'slug', 'name', 'image', 'updated_at']);

            $articles = \App\Models\Article::where('is_published', true)
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->latest('published_at')
                ->get(['id', 'slug', 'image', 'updated_at']);

            $authors = \App\Models\Author::whereNotNull('slug')
                ->get(['slug', 'name', 'updated_at']);

            $appUrl = rtrim(config('app.url'), '/');

            $staticPages = [
                ['url' => $appUrl . '/',            'priority' => '1.0', 'changefreq' => 'weekly',  'lastmod' => now()->toDateString(), 'images' => []],
                ['url' => $appUrl . '/tentang-kami','priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => now()->toDateString(), 'images' => []],
                ['url' => $appUrl . '/produk',      'priority' => '0.9', 'changefreq' => 'weekly',  'lastmod' => now()->toDateString(), 'images' => []],
                ['url' => $appUrl . '/artikel',     'priority' => '0.8', 'changefreq' => 'daily',   'lastmod' => now()->toDateString(), 'images' => []],
                ['url' => $appUrl . '/kontak',      'priority' => '0.7', 'changefreq' => 'monthly', 'lastmod' => now()->toDateString(), 'images' => []],
            ];

            $serviceUrls = $services->map(function ($s) use ($appUrl) {
                $images = [];
                if (!empty($s->image)) {
                    $images[] = [
                        'loc'     => $appUrl . '/storage/' . ltrim($s->image, '/'),
                        'title'   => $s->name,
                        'caption' => $s->name,
                    ];
                }
                return [
                    'url'        => $appUrl . '/produk/' . $s->slug,
                    'priority'   => '0.85',
                    'changefreq' => 'monthly',
                    'lastmod'    => optional($s->updated_at)->toDateString() ?? now()->toDateString(),
                    'images'     => $images,
                ];
            })->toArray();

            $articleUrls = $articles->map(function ($a) use ($appUrl) {
                $images = [];
                if (!empty($a->image)) {
                    $images[] = [
                        'loc'     => $appUrl . '/storage/' . ltrim($a->image, '/'),
                        'title'   => $a->slug,
                        'caption' => $a->slug,
                    ];
                }
                return [
                    'url'        => $appUrl . '/artikel/' . $a->slug,
                    'priority'   => '0.7',
                    'changefreq' => 'monthly',
                    'lastmod'    => optional($a->updated_at)->toDateString() ?? now()->toDateString(),
                    'images'     => $images,
                ];
            })->toArray();

            $authorUrls = $authors->map(fn($a) => [
                'url'        => $appUrl . '/penulis/' . $a->slug,
                'priority'   => '0.6',
                'changefreq' => 'monthly',
                'lastmod'    => optional($a->updated_at)->toDateString() ?? now()->toDateString(),
                'images'     => [],
            ])->toArray();

            $urls    = array_merge($staticPages, $serviceUrls, $articleUrls, $authorUrls);
            $content = view('sitemap', compact('urls'))->render();

            return response($content, 200)->header('Content-Type', 'application/xml');

        } catch (\Throwable $e) {
            Log::error('Sitemap generation failed: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            // Return minimal valid sitemap instead of 500
            $appUrl  = rtrim(config('app.url'), '/');
            $minimal = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
            $minimal .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
            $minimal .= '  <url><loc>' . $appUrl . '/</loc><priority>1.0</priority></url>' . "\n";
            $minimal .= '  <url><loc>' . $appUrl . '/produk</loc><priority>0.9</priority></url>' . "\n";
            $minimal .= '</urlset>';

            return response($minimal, 200)->header('Content-Type', 'application/xml');
        }
    }

    // localeSitemap kept for backward compat but now just redirects to main sitemap
    public function localeSitemap(Request $request, string $sitemapLocale)
    {
        return redirect('/sitemap.xml', 301);
    }
}
