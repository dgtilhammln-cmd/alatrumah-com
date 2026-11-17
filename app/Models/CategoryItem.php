<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryItem extends Model
{
    protected $fillable = ['icon_type', 'icon_value', 'name', 'url', 'badge', 'badge_color', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Scope only genuine product categories (exclude homepage navigation shortcuts like "Lihat Semua")
     */
    public function scopeRealCategories($query)
    {
        return $query->where('is_active', true)
            ->whereNotIn('name', ['Lihat Semua', 'Semua Promo', 'Pengiriman Kilat'])
            ->where(function($q) {
                $q->whereNull('url')
                  ->orWhere('url', '!=', '/produk')
                  ->orWhere('url', 'like', '%kategori=%')
                  ->orWhere('url', 'like', '%category=%');
            })
            ->orderBy('sort_order');
    }

    public function products()
    {
        return $this->hasMany(Service::class, 'product_category_id');
    }

    /**
     * Mendapatkan slug kategori otomatis dari URL atau nama
     */
    public function getSlugAttribute(): string
    {
        if (!empty($this->url)) {
            if (preg_match('/[?&](?:kategori|category)=([^&]+)/i', $this->url, $m)) {
                return $m[1];
            }
            $path = trim(parse_url($this->url, PHP_URL_PATH) ?? '', '/');
            if (!empty($path) && $path !== 'produk') {
                return basename($path);
            }
        }
        return \Illuminate\Support\Str::slug($this->name);
    }
}
