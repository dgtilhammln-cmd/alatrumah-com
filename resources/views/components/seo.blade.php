{{--
    SEO Component — PT. Airlangga Merapi Nusantara
    Variables (semua optional): $seo[], $schema, $breadcrumbs[]
--}}
@php
    $seoData        = $seo        ?? [];
    $schemaData     = $schema     ?? null;
    $breadcrumbData = $breadcrumbs ?? [];
    $appUrl         = rtrim(config('app.url'), '/');

    // Canonical — always use app.url, never localhost
    $rawCanonical   = $seoData['canonical'] ?? url()->current();
    $canonical      = preg_replace('#^https?://[^/]+#', $appUrl, $rawCanonical);

    // OG Image — make absolute using app.url
    $defaultOg      = \App\Models\Setting::get('logo') ? $appUrl . '/storage/' . ltrim(\App\Models\Setting::get('logo'), '/') : $appUrl . '/favicon.ico';
    $rawOg          = $seoData['og_image'] ?? $defaultOg;
    $ogImage        = preg_match('#^https?://#', $rawOg)
                        ? preg_replace('#^https?://[^/]+#', $appUrl, $rawOg)
                        : $appUrl . '/' . ltrim($rawOg, '/');
@endphp
<title>{{ $seoData['title'] ?? __('home.meta_title') }}</title>
<meta name="description" content="{{ $seoData['description'] ?? __('home.meta_desc') }}">
@php
    $robotsDirective = $seoData['robots'] ?? 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1';
@endphp
<meta name="robots" content="{{ $robotsDirective }}">
<meta name="keywords" content="{{ $seoData['keywords'] ?? __('home.meta_keywords') }}">
<link rel="canonical" href="{{ $canonical }}">

@if(\App\Models\Setting::get('google_search_console'))
    {!! \App\Models\Setting::get('google_search_console') !!}
@endif

{{-- Open Graph --}}
<meta property="og:type"         content="{{ $seoData['og_type'] ?? 'website' }}">
<meta property="og:title"        content="{{ $seoData['title'] ?? 'PT. Airlangga Merapi Nusantara' }}">
<meta property="og:description"  content="{{ $seoData['description'] ?? __('home.meta_desc') }}">
<meta property="og:image"        content="{{ $ogImage }}">
<meta property="og:image:width"  content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt"    content="{{ $seoData['title'] ?? 'Cyclevent' }}">
<meta property="og:url"          content="{{ $canonical }}">
<meta property="og:site_name"    content="PT. Airlangga Merapi Nusantara">
<meta property="og:locale"       content="{{ $seoData['locale_og'] ?? 'id_ID' }}">

{{-- Twitter Card --}}
<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="{{ $seoData['title'] ?? 'PT. Airlangga Merapi Nusantara' }}">
<meta name="twitter:description" content="{{ $seoData['description'] ?? '' }}">
<meta name="twitter:image"       content="{{ $ogImage }}">

{{-- Article-specific meta tags --}}
@if(!empty($seoData['article_published']))
<meta property="article:published_time" content="{{ $seoData['article_published'] }}">
<meta property="article:modified_time"  content="{{ $seoData['article_modified'] ?? $seoData['article_published'] }}">
<meta property="article:author"         content="{{ $seoData['article_author'] ?? 'PT. Airlangga Merapi Nusantara' }}">
<meta property="article:section"        content="{{ $seoData['article_section'] ?? 'Artikel' }}">
@endif

{{-- Hreflang alternate links (multi-language SEO) --}}
@if(!empty($seoData['hreflangs']))
    @foreach($seoData['hreflangs'] as $hlLocale => $hlUrl)
    <link rel="alternate" hreflang="{{ $hlLocale === 'id' ? 'id' : $hlLocale }}" href="{{ $hlUrl }}">
    @if($hlLocale === 'ar')
    <link rel="alternate" hreflang="ar-SA" href="{{ $hlUrl }}">
    @endif
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ $seoData['hreflangs']['en'] ?? ($seoData['hreflangs']['id'] ?? $canonical) }}">
@endif

{{-- Geo (local SEO — Surabaya) --}}
<meta name="geo.region"    content="ID-JI">
<meta name="geo.placename" content="Surabaya, Jawa Timur, Indonesia">
<meta name="geo.position"  content="-7.2575;112.7521">
<meta name="ICBM"          content="-7.2575, 112.7521">

{{-- Font preload --}}
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

{{-- JSON-LD LocalBusiness — PT. Airlangga Merapi Nusantara --}}
@php
$lbSchema = json_encode([
    '@@context'     => 'https://schema.org',
    '@@type'        => ['ExportCompany', 'LocalBusiness', 'Organization'],
    '@@id'          => $appUrl . '/#organization',
    'name'          => 'PT. Airlangga Merapi Nusantara',
    'alternateName' => ['AMN', 'Airlangga Merapi Nusantara', 'AMN Charcoal'],
    'description'   => 'PT. Airlangga Merapi Nusantara adalah eksportir arang briket premium berbahan baku kelapa pilihan, berkantor pusat di Surabaya, Jawa Timur, Indonesia. Dipercaya oleh importir di 50+ negara.',
    'url'           => $appUrl,
    'telephone'     => \App\Models\Setting::get('wa_number') ? '+62' . ltrim(\App\Models\Setting::get('wa_number'), '0+62') : '+62-31-XXXX-XXXX',
    'email'         => \App\Models\Setting::get('email') ?? 'info@amncharcoal.com',
    'image'         => $ogImage,
    'logo'          => [
        '@@type' => 'ImageObject',
        'url'    => \App\Models\Setting::get('logo') ? $appUrl . '/storage/' . \App\Models\Setting::get('logo') : $appUrl . '/images/amn/hero-main.png',
    ],
    'priceRange'    => '$$',
    'openingHours'  => ['Mo-Fr 08:00-17:00', 'Sa 08:00-14:00'],
    'currenciesAccepted' => 'USD, EUR, IDR',
    'paymentAccepted'    => 'Bank Transfer, Letter of Credit',
    'areaServed'    => [
        '@@type' => 'GeoCircle',
        'geoMidpoint' => ['@@type'=>'GeoCoordinates','latitude'=>'-7.2575','longitude'=>'112.7521'],
        'geoRadius'   => '20000',
    ],
    'address'       => [
        '@@type'           => 'PostalAddress',
        'streetAddress'    => \App\Models\Setting::get('address') ?? 'Surabaya',
        'addressLocality'  => 'Surabaya',
        'addressRegion'    => 'Jawa Timur',
        'postalCode'       => '60000',
        'addressCountry'   => 'ID',
    ],
    'geo'           => ['@@type'=>'GeoCoordinates','latitude'=>'-7.2575','longitude'=>'112.7521'],
    'hasMap'        => 'https://www.google.com/maps?q=Surabaya,+Jawa+Timur,+Indonesia',
    'contactPoint'  => [
        '@@type'             => 'ContactPoint',
        'telephone'          => \App\Models\Setting::get('wa_number') ? '+62' . ltrim(\App\Models\Setting::get('wa_number'), '0+62') : '+62-31-XXXX-XXXX',
        'contactType'        => 'sales',
        'areaServed'         => ['ID', 'SA', 'AE', 'KR', 'JP', 'DE', 'US', 'GB'],
        'availableLanguage'  => ['Indonesian', 'English', 'Arabic', 'Korean'],
    ],
    'knowsAbout'    => ['Charcoal Briquette', 'Coconut Shell Charcoal', 'Export Commodity', 'Arang Briket', 'BBQ Charcoal', 'Shisha Charcoal'],
    'naics'         => '325998',
    'isicV4'        => '2029',
    'sameAs'        => [$appUrl],
    'founder'       => ['@@type'=>'Person','name'=>'Direktur PT. Airlangga Merapi Nusantara'],
    'foundingLocation' => ['@@type'=>'Place','name'=>'Surabaya, Indonesia'],
], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
@endphp
<script type="application/ld+json">{!! $lbSchema !!}</script>

{{-- Additional schema (Article, FAQ, ImageObject, etc.) — NOT LocalBusiness --}}
@if(!empty($schemaData))
<script type="application/ld+json">{!! $schemaData !!}</script>
@endif

{{-- BreadcrumbList --}}
@if(!empty($breadcrumbData))
@php
    $bcItems = [];
    foreach ($breadcrumbData as $idx => $crumb) {
        $bcItems[] = [
            '@type'    => 'ListItem',
            'position' => $idx + 1,
            'name'     => $crumb['name'] ?? '',
            'item'     => preg_replace('#^https?://[^/]+#', $appUrl, $crumb['url'] ?? ''),
        ];
    }
    $bcJson = json_encode([
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => $bcItems,
    ], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
@endphp
<script type="application/ld+json">{!! $bcJson !!}</script>
@endif
