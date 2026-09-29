<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariantCombination extends Model
{
    protected $fillable = [
        'product_id',
        'option1_value_id',
        'option2_value_id',
        'price',
        'stock',
        'sku',
        'image',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price'     => 'decimal:2',
            'stock'     => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'product_id');
    }

    public function option1Value(): BelongsTo
    {
        return $this->belongsTo(ProductVariantValue::class, 'option1_value_id');
    }

    public function option2Value(): BelongsTo
    {
        return $this->belongsTo(ProductVariantValue::class, 'option2_value_id');
    }

    public function isAvailable(): bool
    {
        return $this->is_active && $this->stock > 0;
    }

    /**
     * Label tampilan kombinasi, e.g. "Merah - S"
     */
    public function label(): string
    {
        $label = $this->option1Value?->value ?? '';
        if ($this->option2Value) {
            $label .= ' - ' . $this->option2Value->value;
        }
        return $label;
    }
}
