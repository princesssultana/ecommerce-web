<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_number', 'subtotal', 'shipping_charge',
        'discount', 'total', 'shipping_name', 'shipping_phone',
        'shipping_address', 'shipping_city', 'shipping_zip',
        'delivery_type', 'order_notes', 'status'
    ];

    // Order কোন user এর
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Order এ অনেক items আছে
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Order এর payment info
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // Order এর invoice
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    // Order number auto-generate: ORD-2026-0001
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            $order->order_number = 'ORD-' . date('Y') . '-' . str_pad(
                Order::count() + 1, 4, '0', STR_PAD_LEFT
            );
        });
    }
}