<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'order_id', 'invoice_number', 'invoice_date', 'status'
    ];

    // কোন order এর invoice
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Invoice number auto-generate: INV-2026-0001
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($invoice) {
            $invoice->invoice_number = 'INV-' . date('Y') . '-' . str_pad(
                Invoice::count() + 1, 4, '0', STR_PAD_LEFT
            );
        });
    }
}