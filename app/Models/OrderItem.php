<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'product_name',
        'price', 'quantity', 'subtotal'
    ];

    // কোন order এর item
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // কোন product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}