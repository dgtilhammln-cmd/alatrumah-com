<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Setting;
use App\Models\WaSetting;
use App\Models\Testimonial;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::active()->ordered()->get();
        $settings = Setting::getAllAsArray();

        $seo = [
            'title'       => $settings['meta_title_services'] ?? 'Daftar Produk Turbine Ventilator Cyclevent | Anti Karat & Bergaransi',
            'description' => $settings['meta_desc_services'] ?? 'Temukan berbagai pilihan tipe Turbine Ventilator dari Cyclevent. Cocok untuk pabrik, gudang, restoran, dan rumah. Sirkulasi udara 24 jam tanpa listrik.',
            'keywords'    => $settings['meta_keywords_services'] ?? 'produk cyclevent, harga turbine ventilator, jual ventilator atap, tipe roof ventilator, spesifikasi turbine ventilator',
            'og_image'    => !empty($settings['og_image_default']) ? asset('storage/'.$settings['og_image_default']) : (!empty($settings['logo']) ? asset('storage/'.$settings['logo']) : asset('images/og-default.jpg')),
            'canonical'   => route_locale('products'),
        ];

        $schema = json_encode([
            '@context' => 'https://schema.org',
            '@type'    => 'ItemList',
            'name'     => 'Produk & Layanan Cyclevent',
            'url'      => route_locale('products'),
            'itemListElement' => $services->map(function($s, $i) {
                return [
                    '@type'    => 'ListItem',
                    'position' => $i + 1,
                    'name'     => $s->name,
                    'url'      => route_locale('products.show', ['slug' => $s->slug]),
                ];
            })->toArray(),
        ]);

        return view('services.index', compact('services', 'settings', 'seo', 'schema'));
    }

    public function show(string $slug)
    {
        $service      = Service::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $settings     = Setting::getAllAsArray();
        $wa           = WaSetting::primary();
        $related      = Service::active()->ordered()->where('id', '!=', $service->id)->limit(4)->get();
        $testimonials = Testimonial::active()->ordered()->get()->unique('name');

        $seo = [
            'title'       => $service->meta_title,
            'description' => $service->meta_desc,
            'keywords'    => $service->meta_keywords,
            'og_image'    => !empty($service->og_image) ? asset('storage/'.$service->og_image) : (!empty($settings['og_image_default']) ? asset('storage/'.$settings['og_image_default']) : asset('images/og-default.jpg')),
            'canonical'   => route_locale('products.show', ['slug' => $slug]),
        ];

        $faq = is_array($service->faqs) ? $service->faqs : [];

        $serviceImage = !empty($service->og_image)
            ? rtrim(config('app.url'), '/') . '/storage/' . $service->og_image
            : (!empty($service->image)
                ? rtrim(config('app.url'), '/') . '/storage/' . $service->image
                : rtrim(config('app.url'), '/') . '/images/og-default.jpg');

        // Fallback FAQs if empty
        if (empty($faq)) {
            $faq = [
                ['q' => 'Apakah Cyclevent Turbine Ventilator memerlukan listrik?', 'a' => 'Sama sekali tidak. Cyclevent beroperasi 100% menggunakan tenaga angin dan perbedaan tekanan udara, sehingga bebas biaya listrik selamanya.'],
                ['q' => 'Berapa lama garansi yang diberikan?', 'a' => 'Kami memberikan garansi resmi untuk produk Cyclevent hingga 15 tahun, mencakup cacat material dan performa putaran mesin.'],
                ['q' => 'Apakah materialnya tahan karat?', 'a' => 'Ya, Cyclevent terbuat dari material Alumunium atau Stainless Steel berkualitas tinggi yang tahan terhadap cuaca ekstrem dan karat.'],
            ];
        }

        $schema = json_encode([
            [
                '@context'    => 'https://schema.org',
                '@type'       => 'Product',
                'name'        => $service->name,
                'image'       => [$serviceImage],
                'description' => strip_tags($service->short_desc ?: $service->name . ' - Cyclevent Turbine Ventilator Berkualitas'),
                'sku'         => 'CYV-' . str_pad($service->id, 4, '0', STR_PAD_LEFT),
                'mpn'         => 'CYV-' . strtoupper(substr($service->slug, 0, 8)),
                'url'         => route_locale('products.show', ['slug' => $slug]),
                'brand'       => ['@type' => 'Brand', 'name' => 'Cyclevent'],
                'offers'      => [
                    '@type'         => 'AggregateOffer',
                    'priceCurrency' => 'IDR',
                    'lowPrice'      => '1500000',
                    'highPrice'     => '5000000',
                    'offerCount'    => '3',
                    'availability'  => 'https://schema.org/InStock',
                    'url'           => route_locale('products.show', ['slug' => $slug]),
                ],
                'aggregateRating' => (function() use ($testimonials) {
                    $count = $testimonials->count();
                    if ($count === 0) {
                        return ['@type' => 'AggregateRating', 'ratingValue' => '4.9', 'reviewCount' => '120', 'bestRating' => '5', 'worstRating' => '1'];
                    }
                    $avg = round($testimonials->avg('rating') ?? 5, 1);
                    return ['@type' => 'AggregateRating', 'ratingValue' => (string)$avg, 'reviewCount' => (string)$count, 'bestRating' => '5', 'worstRating' => '1'];
                })(),
                'review' => $testimonials->take(5)->map(fn($t) => [
                    '@type'        => 'Review',
                    'reviewRating' => ['@type' => 'Rating', 'ratingValue' => (string)($t->rating ?? 5), 'bestRating' => '5'],
                    'author'       => ['@type' => 'Person', 'name' => $t->name],
                    'reviewBody'   => $t->content,
                ])->toArray(),
            ],
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
            ['name' => 'Beranda',        'url' => route_locale('home')],
            ['name' => 'Produk & Layanan', 'url' => route_locale('products')],
            ['name' => $service->name,   'url' => route_locale('products.show', ['slug' => $slug])],
        ];

        return view('services.show', compact('service', 'settings', 'related', 'wa', 'seo', 'schema', 'faq', 'breadcrumbs', 'testimonials'));
    }
}
