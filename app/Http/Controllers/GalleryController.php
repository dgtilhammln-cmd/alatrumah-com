<?php

namespace App\Http\Controllers;

use App\Models\GalleryProject;
use App\Models\Setting;

class GalleryController extends Controller
{
    public function index()
    {
        $category   = request('category');
        $gallery    = GalleryProject::active()->ordered()->byCategory($category)->get();
        $categories = GalleryProject::active()->select('category')->whereNotNull('category')->distinct()->pluck('category')->filter()->values();
        $settings   = Setting::getAllAsArray();

        $seo = [
            'title'      => $settings['meta_title_gallery'] ?? 'Galeri Proyek Crane & Lift | Cyclevent',
            'description'=> $settings['meta_desc_gallery'] ?? 'Dokumentasi proyek pemasangan overhead crane, chain hoist, cargo lift & gantry crane di berbagai industri di Jawa Timur dan seluruh Indonesia.',
            'keywords'   => $settings['meta_keywords_gallery'] ?? 'galeri hoist crane, proyek crane surabaya, pemasangan cargo lift',
            'og_image'   => !empty($settings['og_image_default']) ? asset('storage/'.$settings['og_image_default']) : (!empty($settings['logo']) ? asset('storage/'.$settings['logo']) : asset('images/og-default.jpg')),
            'canonical'  => route('gallery'),
            'robots'     => 'noindex, nofollow',
        ];

        return view('gallery.index', compact('gallery', 'categories', 'category', 'settings', 'seo'));
    }

    public function show(string $slug)
    {
        $item     = GalleryProject::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $related  = GalleryProject::active()->ordered()
            ->where('id', '!=', $item->id)
            ->when($item->category, fn($q) => $q->where('category', $item->category))
            ->limit(4)->get();

        if ($related->count() < 4) {
            $related = GalleryProject::active()->ordered()->where('id', '!=', $item->id)->limit(4)->get();
        }

        $settings = Setting::getAllAsArray();

        $seo = [
            'title'      => $item->meta_title,
            'description'=> $item->meta_desc,
            'og_image'   => $item->og_image_url ?: (!empty($settings['og_image_default']) ? asset('storage/'.$settings['og_image_default']) : asset('images/og-default.jpg')),
            'canonical'  => route('gallery.show', $slug),
            'og_type'    => 'article',
            'robots'     => 'noindex, nofollow',
        ];

        $schema = json_encode([
            '@context'    => 'https://schema.org',
            '@type'       => 'ImageObject',
            'name'        => $item->title,
            'description' => $item->meta_desc,
            'contentUrl'  => $item->image_url,
            'url'         => route('gallery.show', $slug),
            'datePublished'=> $item->created_at->toIso8601String(),
            'author'      => ['@type' => 'Organization', 'name' => 'Cyclevent'],
            'about'       => [
                '@type'    => 'CreativeWork',
                'name'     => $item->title,
                'location' => ['@type' => 'Place', 'name' => $item->location ?? 'Indonesia'],
            ],
        ]);

        $breadcrumbs = [
            ['name' => 'Home',   'url' => route('home')],
            ['name' => 'Galeri', 'url' => route('gallery')],
            ['name' => $item->title, 'url' => route('gallery.show', $slug)],
        ];

        return view('gallery.show', compact('item', 'related', 'settings', 'seo', 'schema', 'breadcrumbs'));
    }
}
