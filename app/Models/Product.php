<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'gallery'           => 'array',
        'sizes'             => 'array',
        'unavailable_sizes' => 'array',
        'colors'            => 'array',
        'featured'          => 'boolean',
        'rating'            => 'decimal:1',
    ];

    // ── Auto slug ──────────────────────────────────────────
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
        });
    }

    // ── Relationships ───────────────────────────────────────
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // ── Accessors ───────────────────────────────────────────

    // Main large image — detail page এ
    public function getMainImageUrlAttribute(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        // image না থাকলে gallery এর first টা দেখাবে
        if (!empty($this->gallery)) {
            return asset('storage/' . $this->gallery[0]);
        }
        return asset('images/placeholder.png');
    }

    // Thumbnail — card/list page এ
    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        return $this->main_image_url; // thumbnail না থাকলে main image
    }

    // Gallery array — সব images (main image সহ)
    public function getAllImagesAttribute(): array
    {
        $imgs = [];

        if ($this->image) {
            $imgs[] = asset('storage/' . $this->image);
        }

        foreach ($this->gallery ?? [] as $g) {
            $url = asset('storage/' . $g);
            if (!in_array($url, $imgs)) {
                $imgs[] = $url;
            }
        }

        return $imgs;
    }

    // Discount %
    public function getDiscountPercentAttribute(): ?int
    {
        if ($this->hasDiscount()) {
            return (int) round(
                (($this->price - $this->discount_price) / $this->price) * 100
            );
        }
        return null;
    }

    // Final price
    public function getFinalPriceAttribute(): float
    {
        return $this->hasDiscount() ? $this->discount_price : $this->price;
    }

    // ── Helpers ─────────────────────────────────────────────
    public function hasDiscount(): bool
    {
        return !is_null($this->discount_price) && $this->discount_price < $this->price;
    }

    // ── Scopes ──────────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }
}