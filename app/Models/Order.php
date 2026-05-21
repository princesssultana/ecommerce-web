<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function getStatusAttribute()
    {
        return $this->attributes['status'] ?? $this->attributes['order_status'] ?? null;
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value;
        $this->attributes['order_status'] = $value;
    }

    public function getOrderStatusAttribute()
    {
        return $this->attributes['order_status'] ?? $this->attributes['status'] ?? null;
    }

    public function setOrderStatusAttribute($value)
    {
        $this->attributes['order_status'] = $value;
        $this->attributes['status'] = $value;
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}