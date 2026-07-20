<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Service;
use App\Models\GalleryProject;
use App\Models\Article;
use App\Models\Client;
use App\Models\Testimonial;
use App\Models\WaSetting;
use App\Models\HeroSlide;
use App\Models\UspItem;
use App\Models\CategoryItem;
use App\Models\PromoSection;

class HomeController extends Controller
{
    public function index()
    {
        $settings     = Setting::getAllAsArray();
        $products     = Service::active()->ordered()->limit(6)->get();
        $gallery      = GalleryProject::active()->ordered()->limit(8)->get();
        $articles     = Article::published()->latest()->limit(3)->get();
        $clients      = Client::active()->ordered()->get();
        $testimonials = Testimonial::active()->ordered()->get()->unique('name');
        $wa           = WaSetting::primary();
        $heroSlides     = HeroSlide::active()->ordered()->where('position', 'hero')->get();
        $utamaBanners   = HeroSlide::active()->ordered()->where('position', 'utama')->limit(2)->get();
        $sampingBanners = HeroSlide::active()->ordered()->where('position', 'samping')->limit(2)->get();
        $uspItems       = UspItem::active()->get();
        $categoryItems  = CategoryItem::active()->get();
        $promoSections  = PromoSection::active()->with('services')->get();

        $siteName = $settings['site_name'] ?? 'Alat Rumah';
        $allProducts = Service::active()->latest()->limit(30)->get();

        $seo = [
            'title'       => $settings['meta_title_home'] ?? $siteName . ' - Toko Alat Rumah Tangga Online',
            'description' => $settings['meta_desc_home']  ?? 'Belanja alat rumah tangga berkualitas di alatrumah.com. Produk lengkap, harga terjangkau, pengiriman ke seluruh Indonesia.',
            'keywords'    => $settings['meta_keywords_home'] ?? 'alat rumah tangga, peralatan rumah, toko alat rumah online, jasa pemasangan',
            'og_image'    => !empty($settings['og_image_default']) ? asset('storage/'.$settings['og_image_default']) : (!empty($settings['logo']) ? asset('storage/'.$settings['logo']) : asset('favicon.ico')),
            'canonical'   => route('home'),
        ];

        return view('home.index', compact('settings', 'products', 'allProducts', 'gallery', 'articles', 'clients', 'testimonials', 'wa', 'seo', 'heroSlides', 'utamaBanners', 'sampingBanners', 'uspItems', 'categoryItems', 'promoSections'));
    }
}

