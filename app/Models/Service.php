<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $fillable = [
        'name', 'slug', 'short_desc', 'description', 'image', 'brochure', 'og_image', 'gallery',
        'specifications', 'faqs',
        'icon', 'order', 'is_active',
        'meta_title', 'meta_desc', 'meta_keywords',
    ];

    protected $casts = [
        'is_active'      => 'boolean',
        'order'          => 'integer',
        'gallery'        => 'array',
        'specifications' => 'array',
        'faqs'           => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function scopeActive(Builder $query): Builder { return $query->where('is_active', true); }
    public function scopeOrdered(Builder $query): Builder { return $query->orderBy('order')->orderBy('id'); }

    public function getImageUrlAttribute(): string
    {
        return $this->image ? asset('storage/'.$this->image) : asset('images/service-default.jpg');
    }
    public function getOgImageUrlAttribute(): string
    {
        return $this->og_image ? asset('storage/'.$this->og_image) : $this->image_url;
    }
    public function getGalleryUrlsAttribute(): array
    {
        $urls = [];
        if (is_array($this->gallery)) {
            foreach ($this->gallery as $img) {
                $urls[] = asset('storage/' . $img);
            }
        }
        return $urls;
    }
    public function getMetaTitleAttribute($v): string
    {
        return $v ?: $this->name . ' | Cyclevent';
    }
    public function getMetaDescAttribute($v): string
    {
        return $v ?: Str::limit(strip_tags($this->short_desc ?? $this->description ?? ''), 155);
    }
    public function getUrlAttribute(): string
    {
        return route('services.show', $this->slug);
    }
}
