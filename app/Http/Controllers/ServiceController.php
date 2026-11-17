<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Setting;
use App\Models\WaSetting;
use App\Models\Testimonial;
use App\Models\Coupon;
use App\Models\CategoryItem;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * Dedicated SEO category landing page: /kategori/{slug}
     */
    public function category(string $slug)
    {
        $allCats = CategoryItem::all();
        $slugClean = strtolower(trim($slug));
        $category = $allCats->first(function($item) use ($slugClean) {
            return strtolower($item->slug) === $slugClean
                || (string)$item->id === $slugClean
                || Str::slug($item->name) === $slugClean
                || strtolower($item->name) === strtolower(str_replace('-', ' ', $slugClean));
        });

        if (!$category) {
            abort(404);
        }

        request()->merge(['kategori' => $category->slug ?: $category->id]);
        return $this->index($category);
    }

    public function index($categoryModel = null)
    {
        $query = Service::active()->ordered();
        
        // Keyword search
        if (request()->filled('q')) {
            $searchTerm = request('q');
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%')
                  ->orWhere('short_desc', 'like', '%' . $searchTerm . '%');
            });
        }

        // Category filter (multiple) - support both 'category' and 'kategori' params
        $categoryParam = request()->filled('category') ? request('category') : request('kategori');
        if ($categoryParam) {
            $rawCats = is_array($categoryParam) ? $categoryParam : explode(',', $categoryParam);
            $cats = array_values(array_filter(array_map('trim', $rawCats), function($c) {
                return $c !== '' && !in_array(strtolower($c), ['all', 'semua', 'lihat-semua']);
            }));

            if (!empty($cats)) {
                // Find matching category IDs flexibly
                $allCats = CategoryItem::all();
                $matchedCatIds = [];
                foreach ($allCats as $catItem) {
                    $catSlug = strtolower($catItem->slug);
                    $catName = strtolower($catItem->name);
                    $catUrl  = strtolower($catItem->url ?? '');
                    $catId   = (string)$catItem->id;

                    foreach ($cats as $searchCat) {
                        $s = strtolower($searchCat);
                        $slugS = Str::slug($s);
                        if ($catId === $s || 
                            $catSlug === $s || 
                            $catSlug === $slugS ||
                            $catName === $s ||
                            str_contains($catUrl, $s) || 
                            str_contains($catUrl, $slugS) ||
                            str_contains($catName, $s)) {
                            $matchedCatIds[] = $catItem->id;
                            break;
                        }
                    }
                }

                if (!empty($matchedCatIds)) {
                    $query->whereIn('product_category_id', array_unique($matchedCatIds));
                } else {
                    $query->whereHas('category', function($q) use ($cats) {
                        $q->where(function($sub) use ($cats) {
                            foreach ($cats as $c) {
                                $sub->orWhere('name', 'like', '%' . $c . '%')
                                    ->orWhere('url', 'like', '%' . $c . '%');
                            }
                        });
                    });
                }
            }
        }

        // Promo filter (support ?promo=1 or ?promo=true)
        if (request()->boolean('promo') || request('promo') === '1' || request('promo') === 'true') {
            $query->where(function($q) {
                $q->where('sale_price', '>', 0)
                  ->whereColumn('sale_price', '<', 'price');
            });
        }

        // Price range filter
        if (request()->filled('price_min')) {
            $query->where(function($q) {
                $q->where('price', '>=', (float) request('price_min'))
                  ->orWhere(function($q2) { $q2->whereNull('price')->orWhere('price', 0); });
            });
        }
        if (request()->filled('price_max') && request('price_max') > 0) {
            $query->where(function($q) {
                $q->where('price', '<=', (float) request('price_max'))
                  ->orWhere(function($q2) { $q2->whereNull('price')->orWhere('price', 0); });
            });
        }

        // Type filter: produk / jasa
        if (request('type') === 'produk') {
            $query->where('price', '>', 0);
        } elseif (request('type') === 'jasa') {
            $query->where(function($q) { $q->whereNull('price')->orWhere('price', 0); });
        }

        // Sorting
        switch (request('sort', 'default')) {
            case 'price_asc':
                $query->orderByRaw('CASE WHEN price IS NULL OR price = 0 THEN 1 ELSE 0 END, price ASC');
                break;
            case 'price_desc':
                $query->orderByRaw('CASE WHEN price IS NULL OR price = 0 THEN 1 ELSE 0 END, price DESC');
                break;
            case 'newest':
                $query->latest();
                break;
            case 'name_az':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->ordered();
                break;
        }
        
        $services   = $query->get();
        $settings   = Setting::getAllAsArray();
        $siteName   = $settings['site_name'] ?? 'Alat Rumah';
        $wa         = WaSetting::primary();

        $totalActiveProducts = Service::active()->count();
        $totalPromoProducts  = Service::active()->where('sale_price', '>', 0)->whereColumn('sale_price', '<', 'price')->count();

        // Categories with counts & shortcut flags
        $categories = CategoryItem::where('is_active', true)
            ->orderBy('sort_order')
            ->withCount(['products' => function($q) { $q->where('is_active', true); }])
            ->get()
            ->map(function($cat) use ($totalActiveProducts, $totalPromoProducts) {
                $nameLower = strtolower(trim($cat->name));
                if (in_array($nameLower, ['lihat semua', 'semua']) || $cat->url === '/produk') {
                    $cat->services_count    = $totalActiveProducts;
                    $cat->is_view_all       = true;
                    $cat->is_promo_shortcut = false;
                } elseif (in_array($nameLower, ['semua promo', 'promo']) || str_contains($cat->url ?? '', 'promo=1')) {
                    $cat->services_count    = $totalPromoProducts;
                    $cat->is_view_all       = false;
                    $cat->is_promo_shortcut = true;
                } else {
                    $cat->services_count    = $cat->products_count;
                    $cat->is_view_all       = false;
                    $cat->is_promo_shortcut = false;
                }
                return $cat;
            });

        // Price range for slider
        $maxPrice = Service::active()->where('price', '>', 0)->max('price') ?? 5000000;

        $hasFilters = request()->hasAny(['q', 'price_min', 'price_max', 'type', 'sort']);

        if ($categoryModel) {
            $catSlug = $categoryModel->slug ?: Str::slug($categoryModel->name);
            $catCanonical = url('/kategori/' . $catSlug);
            $seo = [
                'title'       => "Jual {$categoryModel->name} Terlengkap & Harga Murah | {$siteName}",
                'description' => "Beli aneka produk {$categoryModel->name} terlengkap dengan promo harga terbaik di {$siteName}. 100% original, berkualitas, dan pengiriman cepat ke seluruh Indonesia.",
                'keywords'    => $categoryModel->name . ', beli ' . strtolower($categoryModel->name) . ', alat rumah tangga',
                'og_image'    => !empty($settings['og_image_default']) ? asset('storage/'.$settings['og_image_default']) : (!empty($settings['logo']) ? asset('storage/'.$settings['logo']) : asset('images/og-default.jpg')),
                'canonical'   => $catCanonical,
                'robots'      => $hasFilters ? 'noindex, follow' : 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1',
            ];
            $breadcrumbs = [
                ['name' => 'Beranda',  'url' => route('home')],
                ['name' => 'Produk',   'url' => route('products')],
                ['name' => $categoryModel->name, 'url' => $catCanonical],
            ];
        } else {
            $hasQueryFilters = request()->hasAny(['q', 'category', 'kategori', 'promo', 'price_min', 'price_max', 'type', 'sort']);
            $seo = [
                'title'       => $settings['meta_title_services'] ?? 'Produk & Layanan | ' . $siteName,
                'description' => $settings['meta_desc_services']  ?? 'Temukan berbagai produk alat rumah tangga berkualitas dan perkakas terbaik di ' . $siteName . '. Belanja mudah, aman, dan hemat.',
                'keywords'    => $settings['meta_keywords_services'] ?? 'alat rumah tangga, produk, perkakas, alat kebersihan, dapur',
                'og_image'    => !empty($settings['og_image_default']) ? asset('storage/'.$settings['og_image_default']) : (!empty($settings['logo']) ? asset('storage/'.$settings['logo']) : asset('images/og-default.jpg')),
                'canonical'   => route('products'),
                'robots'      => $hasQueryFilters ? 'noindex, follow' : 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1',
            ];
            $breadcrumbs = [
                ['name' => 'Beranda',          'url' => route('home')],
                ['name' => 'Produk & Layanan', 'url' => route('products')],
            ];
        }

        $schema = json_encode([
            '@context' => 'https://schema.org',
            '@type'    => 'ItemList',
            'name'     => ($categoryModel ? $categoryModel->name . ' - ' : '') . 'Produk & Layanan ' . $siteName,
            'url'      => $categoryModel ? url('/kategori/' . ($categoryModel->slug ?: Str::slug($categoryModel->name))) : route('products'),
            'itemListElement' => $services->map(function($s, $i) {
                return [
                    '@type'    => 'ListItem',
                    'position' => $i + 1,
                    'name'     => $s->name,
                    'url'      => route('products.show', ['slug' => $s->slug]),
                ];
            })->toArray(),
        ]);

        $currentCategory = $categoryModel;

        return view('services.index', compact('services', 'settings', 'seo', 'schema', 'categories', 'wa', 'maxPrice', 'breadcrumbs', 'currentCategory'));
    }

    public function show(string $slug)
    {
        $service      = Service::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $service->increment('views_count');
        $settings     = Setting::getAllAsArray();
        $wa           = WaSetting::primary();
        $related      = Service::active()->ordered()->where('id', '!=', $service->id)->limit(4)->get();
        $testimonials = Testimonial::active()->ordered()->get()->unique('name');
        $siteName     = $settings['site_name'] ?? 'Alat Rumah';

        // Dynamic Rich Meta Description (Google Quality Guidelines: 140-160 chars)
        $rawDesc = trim($service->meta_desc ?: $service->short_desc ?: '');
        if (empty($rawDesc) || mb_strlen($rawDesc) < 60) {
            $snippet = !empty($rawDesc) ? rtrim($rawDesc, '.') . '. ' : '';
            $catText = $service->category ? 'kategori ' . $service->category->name . ' ' : '';
            $metaDescription = "Beli {$service->name} {$catText}terbaik & original di {$siteName}. {$snippet}Kualitas terjamin, harga murah, dan pengiriman aman ke seluruh Indonesia.";
        } else {
            $metaDescription = $rawDesc;
        }

        // Standardized Brand Title
        $metaTitle = $service->meta_title ?: $service->name;
        if (!str_contains(strtolower($metaTitle), strtolower($siteName))) {
            $metaTitle = $metaTitle . ' | ' . $siteName;
        }

        $seo = [
            'title'       => $metaTitle,
            'description' => $metaDescription,
            'keywords'    => $service->meta_keywords ?: ($service->name . ', beli ' . $service->name . ', alat rumah tangga'),
            'og_image'    => !empty($service->og_image) ? asset('storage/'.$service->og_image) : (!empty($settings['og_image_default']) ? asset('storage/'.$settings['og_image_default']) : asset('images/og-default.jpg')),
            'canonical'   => route('products.show', ['slug' => $slug]),
            'og_type'     => 'product',
        ];

        $faq = is_array($service->faqs) ? $service->faqs : [];

        // Fallback FAQs jika kosong
        if (empty($faq)) {
            $faq = [
                ['q' => 'Bagaimana cara memesan produk ini?', 'a' => 'Anda dapat memesan melalui tombol "Tambah ke Keranjang" atau menghubungi tim kami melalui WhatsApp untuk konsultasi lebih lanjut.'],
                ['q' => 'Apakah tersedia layanan pengiriman ke seluruh Indonesia?', 'a' => 'Ya, kami melayani pengiriman ke seluruh wilayah Indonesia.'],
                ['q' => 'Apakah tersedia garansi produk?', 'a' => 'Setiap produk dilengkapi dengan garansi sesuai ketentuan yang berlaku. Hubungi kami untuk informasi lebih lanjut.'],
            ];
        }

        $serviceImage = !empty($service->image)
            ? rtrim(config('app.url'), '/') . '/storage/' . $service->image
            : (!empty($service->og_image)
                ? rtrim(config('app.url'), '/') . '/storage/' . $service->og_image
                : rtrim(config('app.url'), '/') . '/images/og-default.jpg');

        $schemaDesc = strip_tags($service->short_desc ?: $service->description ?: $service->name);
        if (strlen($schemaDesc) < 50) {
            $schemaDesc = $schemaDesc . ' - Dapatkan produk original ini dengan penawaran harga terbaik hanya di ' . $siteName . '. Beli sekarang juga dengan jaminan pengiriman cepat dan aman.';
        }

        $finalPrice = $service->sale_price > 0 && $service->sale_price < $service->price ? $service->sale_price : $service->price;
        if (empty($finalPrice)) {
            $finalPrice = 0;
        }

        $productSchema = [
            '@context'    => 'https://schema.org',
            '@type'       => 'Product',
            'name'        => $service->name,
            'image'       => [$serviceImage],
            'description' => $schemaDesc,
            'sku'         => $service->sku ?? 'SKU-' . str_pad($service->id, 4, '0', STR_PAD_LEFT),
            'url'         => route('products.show', ['slug' => $slug]),
            'brand'       => ['@type' => 'Brand', 'name' => $siteName],
            'offers'      => [
                '@type'         => 'Offer',
                'priceCurrency' => 'IDR',
                'price'         => (string) $finalPrice,
                'priceValidUntil' => date('Y-m-d', strtotime('+1 year')),
                'availability'  => $service->is_available ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
                'url'           => route('products.show', ['slug' => $slug]),
                'seller'        => ['@type' => 'Organization', 'name' => $siteName],
            ],
        ];

        if ($service->rating > 0) {
            $productSchema['aggregateRating'] = [
                '@type' => 'AggregateRating',
                'ratingValue' => $service->rating,
                'reviewCount' => max(1, $service->sold_count ?? 1),
            ];
        }

        $reviews = [];
        if ($testimonials && $testimonials->count() > 0) {
            foreach ($testimonials->take(3) as $t) {
                $reviews[] = [
                    '@type' => 'Review',
                    'reviewRating' => ['@type' => 'Rating', 'ratingValue' => $t->rating ?? 5],
                    'author' => ['@type' => 'Person', 'name' => $t->name ?? 'Pelanggan'],
                    'reviewBody' => strip_tags($t->content ?? 'Produk sangat bagus dan memuaskan.')
                ];
            }
        } else {
            $reviews[] = [
                '@type' => 'Review',
                'reviewRating' => ['@type' => 'Rating', 'ratingValue' => 5],
                'author' => ['@type' => 'Person', 'name' => 'Pelanggan ' . $siteName],
                'reviewBody' => 'Produk original, packing rapi, dan pengiriman sangat cepat. Sangat direkomendasikan!'
            ];
        }
        $productSchema['review'] = $reviews;

        $schema = json_encode([
            $productSchema,
            [
                '@context'   => 'https://schema.org',
                '@type'      => 'FAQPage',
                'mainEntity' => collect($faq)->map(fn($item) => [
                    '@type'          => 'Question',
                    'name'           => $item['q'] ?? '',
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => $item['a'] ?? ''],
                ])->toArray(),
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $breadcrumbs = [
            ['name' => 'Beranda',  'url' => route('home')],
            ['name' => 'Produk',   'url' => route('products')],
        ];
        if ($service->category) {
            $catSlug = $service->category->slug ?: Str::slug($service->category->name);
            $breadcrumbs[] = [
                'name' => $service->category->name,
                'url'  => url('/kategori/' . $catSlug),
            ];
        }
        $breadcrumbs[] = [
            'name' => $service->name,
            'url'  => route('products.show', ['slug' => $slug]),
        ];

        $coupons = Coupon::active()->latest()->take(3)->get();

        return view('services.show', compact('service', 'settings', 'related', 'wa', 'seo', 'schema', 'faq', 'breadcrumbs', 'testimonials', 'coupons'));
    }
}
