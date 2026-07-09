<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class ArticleController extends Controller
{
    protected $locales = ['id', 'en', 'ar', 'ko'];

    protected function localizedUrl(string $locale, string $routeName, array $params = []): string
    {
        // Delegate to the global route_locale() helper
        return route_locale($routeName, $params, $locale);
    }

    public function index()
    {
        $locale   = app()->getLocale();
        
        // Lazy load strategy
        $withArray = [
            'authorRel', 
            'translations' => function($query) use ($locale) {
                $query->whereIn('locale', [$locale, 'en', 'id']);
            }
        ];

        $query = Article::published()->with($withArray)->latest();

        if ($locale !== 'id') {
            $query->whereHas('translations', fn($q) => $q->where('locale', $locale)->where('is_complete', true));
        }

        $articles = $query->paginate(9);

        // Categories & Popular (cached)
        $categories = Cache::remember("articles.categories.{$locale}", 3600, function() {
            return Article::published()->select('category')->whereNotNull('category')->distinct()->pluck('category');
        });
        
        $popular = Cache::remember("articles.popular.{$locale}", 3600, function() use ($withArray) {
            return Article::published()->with($withArray)->orderByDesc('views')->limit(5)->get();
        });

        $settings   = Setting::getAllAsArray();
        $appUrl     = rtrim(config('app.url'), '/');

        $hreflangs = [];
        $hreflangs['id'] = $this->localizedUrl('id', 'articles');
        foreach ($this->locales as $lc) {
            if ($lc !== 'id') $hreflangs[$lc] = $this->localizedUrl($lc, 'articles');
        }

        $metaTitles = [
            'id' => $settings['meta_title_articles']  ?? 'Artikel & Tips Sistem Sirkulasi Udara | Blog Cyclevent',
            'en' => 'Articles & Tips on Air Circulation Systems | Cyclevent Blog',
            'ar' => 'مقالات ونصائح حول أنظمة تهوية الهواء | مدونة Cyclevent',
            'ko' => '공기 순환 시스템 기사 및 팁 | Cyclevent 블로그',
        ];
        $metaDescs = [
            'id' => $settings['meta_desc_articles'] ?? 'Kumpulan artikel informatif tentang sistem ventilasi industri, cara memilih turbine ventilator yang tepat, dan tips menjaga sirkulasi udara bangunan.',
            'en' => 'Browse informative articles about industrial ventilation systems, how to choose the right turbine ventilator, and tips for maintaining building air circulation.',
            'ar' => 'تصفح مقالات إعلامية حول أنظمة التهوية الصناعية وكيفية اختيار مروحة توربين مناسبة ونصائح للحفاظ على تهوية المباني.',
            'ko' => '산업용 환기 시스템, 적절한 터빈 환풍기 선택 방법, 건물 공기 순환 유지 팁에 관한 정보성 기사를 탐색하세요.',
        ];

        $seo = [
            'title'       => $metaTitles[$locale] ?? $metaTitles['id'],
            'description' => $metaDescs[$locale]  ?? $metaDescs['id'],
            'og_image'    => !empty($settings['og_image_default']) ? $appUrl.'/storage/'.$settings['og_image_default'] : $appUrl.'/images/og-default.jpg',
            'canonical'   => $this->localizedUrl($locale, 'articles'),
            'keywords'    => $settings['meta_keywords_articles'] ?? 'artikel ventilasi, tips sirkulasi udara, manfaat turbine ventilator, blog cyclevent',
            'locale_og'   => $this->getOgLocale($locale),
            'hreflangs'   => $hreflangs,
        ];

        $breadcrumbs = [
            ['name' => 'Home',    'url' => route_locale('home')],
            ['name' => 'Artikel', 'url' => route_locale('articles')],
        ];

        return view('articles.index', compact('articles','categories','popular','settings','seo','breadcrumbs','locale','hreflangs'));
    }

    public function show(string $slug)
    {
        $locale = app()->getLocale();
        
        $article = Cache::remember("article.{$slug}.{$locale}", 3600, function() use ($slug) {
            return Article::published()
                ->with(['translations', 'authorRel.translations']) // Eager load translations for single view
                ->where('slug', $slug)
                ->firstOrFail();
        });

        // Track views without caching
        $article->incrementViews();

        $trans = $article->translate($locale);
        $isComplete = $locale === 'id' ? true : ($trans?->is_complete ?? false);

        $related = Cache::remember("article.related.{$article->id}.{$locale}", 3600, function() use ($article) {
            $q = Article::published()->with(['authorRel', 'translations'])->where('id', '!=', $article->id);
            $rel = (clone $q)->where('category', $article->category)->latest()->limit(3)->get();
            if ($rel->count() < 3) {
                $rel = $q->latest()->limit(3)->get();
            }
            return $rel;
        });

        $settings = Setting::getAllAsArray();
        $appUrl   = rtrim(config('app.url'), '/');

        $ogImg = $article->getRawOriginal('og_image')
            ? $appUrl.'/storage/'.$article->getRawOriginal('og_image')
            : ($article->getRawOriginal('image')
                ? $appUrl.'/storage/'.$article->getRawOriginal('image')
                : (!empty($settings['og_image_default'])
                    ? $appUrl.'/storage/'.$settings['og_image_default']
                    : $appUrl.'/images/og-default.jpg'));

        $wordCount = str_word_count(strip_tags($trans?->content ?? ''));
        $readTime  = max(1, (int) ceil($wordCount / 200));

        // Generate Hreflangs only for completed locales
        $hreflangs = [];
        $completedLocales = $article->translations->where('is_complete', true)->pluck('locale')->toArray();
        foreach ($this->locales as $lc) {
            if ($lc === 'id' || in_array($lc, $completedLocales)) {
                $hreflangs[$lc] = $this->localizedUrl($lc, 'articles.show', ['slug' => $slug]);
            }
        }

        $seo = [
            'title'             => $trans?->meta_title ?: ($trans?->title ? ($trans->title . ' | Cyclevent') : ''),
            'description'       => $trans?->meta_desc ?: Str::limit(strip_tags($trans?->excerpt ?? $trans?->content ?? ''), 155),
            'keywords'          => $trans?->meta_keywords,
            'og_image'          => $ogImg,
            'canonical'         => $this->localizedUrl($locale, 'articles.show', ['slug' => $slug]),
            'og_type'           => 'article',
            'locale_og'         => $this->getOgLocale($locale),
            'hreflangs'         => $hreflangs,
            'article_published' => $article->published_at?->toIso8601String(),
            'article_modified'  => $article->updated_at->toIso8601String(),
            'article_author'    => $article->authorRel?->name ?? 'Tim Cyclevent',
            'article_section'   => $article->category ?? 'Artikel',
            'robots'            => !$isComplete ? 'noindex, follow' : 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1',
        ];

        $breadcrumbs = [
            ['name' => 'Home',    'url' => route_locale('home')],
            ['name' => 'Artikel', 'url' => route_locale('articles')],
            ['name' => $trans?->title ?? $article->slug, 'url' => route_locale('articles.show', ['slug' => $slug])],
        ];

        // Schema.org
        $schemas = [];
        
        $authorData = [
            '@type' => 'Organization',
            'name'  => 'Tim Cyclevent'
        ];
        
        if ($article->authorRel) {
            $authorData = [
                '@type' => 'Person',
                'name'  => $article->authorRel->name,
                'url'   => $this->localizedUrl($locale, 'articles'), // Could be author archive if exists
            ];
            if ($article->authorRel->photo) {
                $authorData['image'] = $appUrl.'/storage/'.$article->authorRel->photo;
            }
        }

        $schemas[] = [
            '@context'         => 'https://schema.org',
            '@type'            => 'Article',
            'headline'         => $trans?->title,
            'description'      => $trans?->excerpt,
            'abstract'         => $trans?->featured_snippet,
            'image'            => $ogImg,
            'datePublished'    => $article->published_at?->toIso8601String(),
            'dateModified'     => $article->updated_at->toIso8601String(),
            'wordCount'        => $wordCount,
            'articleSection'   => $article->category ?? 'Artikel',
            'inLanguage'       => $this->getSchemaLocale($locale),
            'author'           => $authorData,
            'publisher'        => [
                '@type'  => 'Organization',
                'name'   => 'Cyclevent',
                '@id'    => $appUrl.'/#organization',
                'logo'   => ['@type' => 'ImageObject', 'url' => $appUrl.'/images/logo.png'],
            ],
            'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $this->localizedUrl($locale, 'articles.show', ['slug' => $slug])],
            'url'              => $this->localizedUrl($locale, 'articles.show', ['slug' => $slug]),
        ];

        $faqs = $trans?->faqs ?? [];
        $validFaqs = array_filter((array)$faqs, fn($f) => !empty($f['q']) && !empty($f['a']));
        if (!empty($validFaqs)) {
            $schemas[] = [
                '@context'   => 'https://schema.org',
                '@type'      => 'FAQPage',
                'mainEntity' => array_values(array_map(fn($f) => [
                    '@type'          => 'Question',
                    'name'           => $f['q'],
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
                ], $validFaqs)),
            ];
        }

        $schemas[] = [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => array_values(array_map(fn($crumb, $i) => [
                '@type'    => 'ListItem',
                'position' => $i + 1,
                'name'     => $crumb['name'],
                'item'     => $crumb['url'],
            ], $breadcrumbs, array_keys($breadcrumbs))),
        ];

        $schema = json_encode(
            ['@context' => 'https://schema.org', '@graph' => array_map(
                fn($s) => array_diff_key($s, ['@context' => '']),
                $schemas
            )],
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );

        return view('articles.show', compact('article','trans','related','settings','seo','schema','breadcrumbs','readTime','wordCount','locale','hreflangs'));
    }

    protected function getOgLocale(string $locale): string
    {
        return match($locale) {
            'en' => 'en_US',
            'ar' => 'ar_SA',
            'ko' => 'ko_KR',
            default => 'id_ID',
        };
    }

    protected function getSchemaLocale(string $locale): string
    {
        return match($locale) {
            'en' => 'en-US',
            'ar' => 'ar-SA',
            'ko' => 'ko-KR',
            default => 'id-ID',
        };
    }
}
