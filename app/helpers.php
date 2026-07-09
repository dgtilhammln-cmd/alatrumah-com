<?php

if (!function_exists('route_locale')) {
    /**
     * Generate a localized URL for a named route.
     *
     * Route naming convention in web.php:
     *   home.id, about.id, articles.id, articles.show.id, products.id, etc.
     *
     * Usage:
     *   route_locale('articles.show', ['slug' => $article->slug])
     *   route_locale('articles.show', ['slug' => $article->slug], 'ar')
     *
     * @param  string      $name    Base route name without locale suffix (e.g. 'articles.show')
     * @param  mixed       $params  Additional route parameters (do NOT include 'locale')
     * @param  string|null $locale  Target locale; defaults to current app locale
     * @return string
     */
    function route_locale(string $name, mixed $params = [], ?string $locale = null): string
    {
        $validLocales = ['id', 'en', 'ar', 'ko'];
        $locale       = $locale ?? app()->getLocale();
        $locale       = in_array($locale, $validLocales) ? $locale : 'en';

        // Strip any existing locale suffix
        $baseName = preg_replace('/\.(id|en|ar|ko)$/', '', $name);

        if (!is_array($params)) {
            $params = [$params];
        }

        // All localized public routes take a {locale} param as the first segment
        $routeParams = array_merge(['locale' => $locale], $params);


        // Route names in web.php are stored as "home.id", "about.id", etc.
        // The suffix is always ".id" (because resource group uses that suffix for ALL locales).
        // The {locale} URL parameter controls the actual locale served.
        $routeName = $baseName . '.id';

        if (\Illuminate\Support\Facades\Route::has($routeName)) {
            return route($routeName, $routeParams);
        }

        // Fallback: build URL manually
        return url('/' . $locale);
    }
}

if (!function_exists('current_locale')) {
    /**
     * Return the currently active locale.
     */
    function current_locale(): string
    {
        return app()->getLocale();
    }
}

if (!function_exists('switch_locale_url')) {
    /**
     * Swap the locale prefix in the current request URL.
     *
     * Example:
     *   Current URL: /en/articles/how-to-install
     *   switch_locale_url('ar') → /ar/articles/how-to-install
     *
     * @param  string $targetLocale
     * @return string
     */
    function switch_locale_url(string $targetLocale): string
    {
        $validLocales = ['id', 'en', 'ar', 'ko'];
        $targetLocale = in_array($targetLocale, $validLocales) ? $targetLocale : 'en';

        $path     = request()->path();              // e.g. "en/articles/slug"
        $segments = explode('/', ltrim($path, '/'));
        $firstSeg = $segments[0] ?? '';

        if (in_array($firstSeg, $validLocales)) {
            $segments[0] = $targetLocale;
        } else {
            array_unshift($segments, $targetLocale);
        }

        return url(implode('/', $segments));
    }
}

if (!function_exists('locale_labels')) {
    /**
     * Return all locale metadata: svg_flag (inline SVG), name, dir.
     * Uses real SVG flag icons instead of emoji for cross-platform consistency.
     */
    function locale_labels(): array
    {
        // Inline SVG flags — lightweight, no external dependency
        $flags = [
            // UK / Great Britain
            'en' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 30" width="22" height="14" style="border-radius:2px;display:inline-block;vertical-align:middle;flex-shrink:0;">'
                  . '<clipPath id="c"><path d="M0 0v30h60V0z"/></clipPath>'
                  . '<clipPath id="t"><path d="M30 15h30v15zv15H0zH0V0zV0h30z"/></clipPath>'
                  . '<g clip-path="url(#c)">'
                  . '<path d="M0 0v30h60V0z" fill="#012169"/>'
                  . '<path d="M0 0l60 30m0-30L0 30" stroke="#fff" stroke-width="6"/>'
                  . '<path d="M0 0l60 30m0-30L0 30" clip-path="url(#t)" stroke="#C8102E" stroke-width="4"/>'
                  . '<path d="M30 0v30M0 15h60" stroke="#fff" stroke-width="10"/>'
                  . '<path d="M30 0v30M0 15h60" stroke="#C8102E" stroke-width="6"/>'
                  . '</g></svg>',

            // Indonesia
            'id' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 14" width="22" height="14" style="border-radius:2px;display:inline-block;vertical-align:middle;flex-shrink:0;">'
                  . '<rect width="22" height="7" fill="#CE1126"/>'
                  . '<rect y="7" width="22" height="7" fill="#FFFFFF"/>'
                  . '</svg>',

            // Saudi Arabia / Arabic
            'ar' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 14" width="22" height="14" style="border-radius:2px;display:inline-block;vertical-align:middle;flex-shrink:0;">'
                  . '<rect width="22" height="14" fill="#006C35"/>'
                  . '<text x="11" y="10" text-anchor="middle" fill="#FFFFFF" font-size="6" font-family="serif">&#x644;&#x627;</text>'
                  . '</svg>',

            // South Korea
            'ko' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 14" width="22" height="14" style="border-radius:2px;display:inline-block;vertical-align:middle;flex-shrink:0;">'
                  . '<rect width="22" height="14" fill="#FFFFFF"/>'
                  . '<circle cx="11" cy="7" r="3.5" fill="#CD2E3A"/>'
                  . '<path d="M11 7 a3.5 3.5 0 0 1 0-3.5 a3.5 3.5 0 0 0 0 3.5" fill="#0047A0"/>'
                  . '</svg>',
        ];

        return [
            'en' => ['flag' => $flags['en'], 'code' => 'EN', 'name' => 'English',   'dir' => 'ltr'],
            'id' => ['flag' => $flags['id'], 'code' => 'ID', 'name' => 'Indonesia',  'dir' => 'ltr'],
            'ar' => ['flag' => $flags['ar'], 'code' => 'AR', 'name' => 'العربية',    'dir' => 'rtl'],
            'ko' => ['flag' => $flags['ko'], 'code' => 'KO', 'name' => '한국어',     'dir' => 'ltr'],
        ];
    }
}
