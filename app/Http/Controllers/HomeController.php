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

class HomeController extends Controller
{
    public function index()
    {
        $settings     = Setting::getAllAsArray();
        $products     = Service::active()->ordered()->limit(5)->get();
        $gallery      = GalleryProject::active()->ordered()->limit(8)->get();
        $articles     = Article::published()->latest()->limit(3)->get();
        $clients      = Client::active()->ordered()->get();
        $testimonials = Testimonial::active()->ordered()->get()->unique('name');
        $wa           = WaSetting::primary();
        $heroSlides   = HeroSlide::active()->ordered()->limit(5)->get();

        $seo = [
            'title'       => $settings['meta_title_home'] ?? 'Cyclevent — Turbine Ventilator Non-Electric #1 Indonesia | PT. Hiranatha Makmur Sukses',
            'description' => $settings['meta_desc_home']  ?? 'Produsen turbine ventilator non-electric terpercaya sejak 2007. Garansi 15 tahun tidak berkarat. 5 tipe: CV-45, CV-60, CV-75, CV-90, CV-105. Gratis konsultasi: 0812-9656-5757.',
            'keywords'    => $settings['meta_keywords_home'] ?? 'turbine ventilator, ventilator atap, cyclevent, roof ventilator, ventilator non electric, kipas angin atap, vent turbine, ventilasi pabrik, ventilasi gudang',
            'og_image'    => !empty($settings['og_image_default']) ? asset('storage/'.$settings['og_image_default']) : (!empty($settings['logo']) ? asset('storage/'.$settings['logo']) : asset('favicon.ico')),
            'canonical'   => route_locale('home'),
        ];

        return view('home.index', compact('settings', 'products', 'gallery', 'articles', 'clients', 'testimonials', 'wa', 'seo', 'heroSlides'));
    }
}
