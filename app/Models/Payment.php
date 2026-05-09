<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id', 'method', 'transaction_id',
        'amount', 'status', 'paid_at'
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    // কোন order এর payment
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}