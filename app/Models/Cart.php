<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id', 'product_id', 'quantity'
    ];

    // Cart item কোন user এর
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Cart item কোন product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Item এর total price
    public function getItemTotalAttribute()
    {
        return $this->product->final_price * $this->quantity;
    }
}