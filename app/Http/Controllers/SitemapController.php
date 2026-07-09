<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Article;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SitemapController extends Controller
{
    protected array $locales = ['id', 'en', 'ar', 'ko'];

    public function index(Request $request)
    {
        // Return XML Sitemap Index containing links to locale-specific sitemaps
        $content  = '<?xml version="1.0" encoding="UTF-8"?>';
        $content .= '<?xml-stylesheet type="text/xsl" href="/sitemap.xsl"?>';
        $content .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($this->locales as $locale) {
            $content .= '<sitemap>';
            $content .= '<loc>' . url('/sitemap-' . $locale . '.xml') . '</loc>';
            $content .= '<lastmod>' . now()->startOfDay()->toAtomString() . '</lastmod>';
            $content .= '</sitemap>';
        }

        $content .= '</sitemapindex>';

        return response($content, 200)->header('Content-Type', 'application/xml');
    }

    public function localeSitemap(Request $request, string $sitemapLocale)
    {
        if (!in_array($sitemapLocale, $this->locales)) {
            abort(404);
        }

        App::setLocale($sitemapLocale);

        $services = Service::active()->ordered()->get(['slug', 'name', 'updated_at']);

        $articleQuery = Article::published()->with(['translations' => function ($q) use ($sitemapLocale) {
            $q->where('locale', $sitemapLocale);
        }]);

        if ($sitemapLocale !== 'id') {
            $articleQuery->whereHas('translations', function ($q) use ($sitemapLocale) {
                $q->where('locale', $sitemapLocale)->where('is_complete', true);
            });
        }
        $articles = $articleQuery->latest()->get();

        // Static pages — using global route_locale() helper
        $staticPages = [];
        $staticRoutes = [
            'home'     => ['changefreq' => 'weekly',  'priority' => '1.0'],
            'about'    => ['changefreq' => 'monthly', 'priority' => '0.8'],
            'products' => ['changefreq' => 'weekly',  'priority' => '0.9'],
            'articles' => ['changefreq' => 'daily',   'priority' => '0.8'],
            'contact'  => ['changefreq' => 'monthly', 'priority' => '0.7'],
        ];

        foreach ($staticRoutes as $routeName => $meta) {
            try {
                $url = route_locale($routeName, [], $sitemapLocale);
                $staticPages[] = [
                    'url'        => $url,
                    'priority'   => $meta['priority'],
                    'changefreq' => $meta['changefreq'],
                    'lastmod'    => now()->toDateString(),
                ];
            } catch (\Exception $e) {
                // Skip if route can't be generated
            }
        }

        // Products (service detail pages)
        $serviceUrls = [];
        foreach ($services as $service) {
            try {
                $serviceUrls[] = [
                    'url'        => route_locale('products.show', ['slug' => $service->slug], $sitemapLocale),
                    'priority'   => '0.85',
                    'changefreq' => 'monthly',
                    'lastmod'    => $service->updated_at->toDateString(),
                ];
            } catch (\Exception $e) {
                // Skip
            }
        }

        // Articles
        $articleUrls = [];
        foreach ($articles as $a) {
            $trans   = $a->translations->first();
            $lastmod = $trans ? $trans->updated_at : $a->updated_at;
            try {
                $articleUrls[] = [
                    'url'        => route_locale('articles.show', ['slug' => $a->slug], $sitemapLocale),
                    'priority'   => '0.7',
                    'changefreq' => 'monthly',
                    'lastmod'    => $lastmod->toDateString(),
                ];
            } catch (\Exception $e) {
                // Skip
            }
        }

        // Authors
        $authors = Author::whereNotNull('slug')->get(['slug', 'name', 'updated_at']);
        $authorUrls = [];
        foreach ($authors as $author) {
            try {
                $authorUrls[] = [
                    'url'        => route_locale('author.show', ['slug' => $author->slug], $sitemapLocale),
                    'priority'   => '0.6',
                    'changefreq' => 'monthly',
                    'lastmod'    => $author->updated_at->toDateString(),
                ];
            } catch (\Exception $e) {
                // Skip
            }
        }

        $urls    = array_merge($staticPages, $serviceUrls, $articleUrls, $authorUrls);
        $content = view('sitemap', compact('urls'))->render();

        return response($content, 200)->header('Content-Type', 'application/xml');
    }

    private function generateHtmlSitemap()
    {
        $services = Service::active()->ordered()->get(['slug', 'name', 'updated_at']);
        $articles = Article::published()->latest()->get(['slug', 'title', 'updated_at']);
        $authors  = Author::whereNotNull('slug')->get(['slug', 'name', 'updated_at']);

        $staticPages = [
            ['url' => route_locale('home'),     'label' => 'Beranda',       'priority' => '1.0', 'changefreq' => 'weekly',  'lastmod' => now()->toDateString()],
            ['url' => route_locale('about'),    'label' => 'Tentang Kami',  'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => now()->toDateString()],
            ['url' => route_locale('products'), 'label' => 'Produk',        'priority' => '0.9', 'changefreq' => 'weekly',  'lastmod' => now()->toDateString()],
            ['url' => route_locale('articles'), 'label' => 'Artikel',       'priority' => '0.8', 'changefreq' => 'daily',   'lastmod' => now()->toDateString()],
            ['url' => route_locale('contact'),  'label' => 'Kontak',        'priority' => '0.7', 'changefreq' => 'monthly', 'lastmod' => now()->toDateString()],
        ];

        $serviceUrls = $services->map(fn($s) => [
            'url'        => route_locale('products.show', ['slug' => $s->slug]),
            'label'      => $s->name,
            'priority'   => '0.85',
            'changefreq' => 'monthly',
            'lastmod'    => $s->updated_at->toDateString(),
        ])->toArray();

        $articleUrls = $articles->map(fn($a) => [
            'url'        => route_locale('articles.show', ['slug' => $a->slug]),
            'label'      => $a->title,
            'priority'   => '0.7',
            'changefreq' => 'monthly',
            'lastmod'    => $a->updated_at->toDateString(),
        ])->toArray();

        $authorUrls = $authors->map(fn($a) => [
            'url'        => route_locale('author.show', ['slug' => $a->slug]),
            'label'      => $a->name,
            'priority'   => '0.6',
            'changefreq' => 'monthly',
            'lastmod'    => $a->updated_at->toDateString(),
        ])->toArray();

        $urls = array_merge($staticPages, $serviceUrls, $articleUrls, $authorUrls);
        return view('sitemap-html', compact('staticPages', 'serviceUrls', 'articleUrls', 'authorUrls', 'urls'));
    }
}
