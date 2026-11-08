<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];


    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }

    public function getTotalAttribute($value)
    {
        return number_format($value, 2, '.', ',');
    }

    // scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }
    public function scopeCanceled($query)
    {
        return $query->where('status', 'cancelled');
    }
    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }
}
