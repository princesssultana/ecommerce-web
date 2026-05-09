<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;

     protected $guarded = [];
    

    // slug auto-generate
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
        });
    }

    // Product কোন category তে আছে
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
     // Discount percentage calculate করবে
    public function getDiscountPercentAttribute()
    {
        if ($this->discount_price) {
            return round((($this->price - $this->discount_price) / $this->price) * 100);
        }
        return null;
    }

    // Product এর অনেক images আছে
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Product এর primary/main image
    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    // Product এর order history
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Discount আছে কিনা check
    public function hasDiscount()
    {
        return !is_null($this->discount_price) && $this->discount_price < $this->price;
    }

    // Final price — discount থাকলে discount price, না থাকলে regular price
    public function getFinalPriceAttribute()
    {
        return $this->hasDiscount() ? $this->discount_price : $this->price;
    }
}