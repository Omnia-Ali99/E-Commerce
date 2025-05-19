<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
     use HasFactory;
    protected $table = 'coupons';
    protected $fillable = [
        'code',
        'discount_precentage',
        'start_date',
        'end_date',
        'limit',
        'time_used',
        'is_active',
    ];
    // accessor
    public function getCreatedAtAttribute($value)
    {
        return date('d/m/Y H:i a', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d/m/Y H:i a', strtotime($value));
    }



    // Scopes
    public function scopeValid($query)
    {
        return $query->where('is_active', 1)
            ->where('time_used', '<', 'limit')
            ->where('end_date', '>', now());
    }

    public function scopeNotValid($query)
    {
        return $query->where('is_active', 0)
            ->orWhere('time_used', '>=', 'limit')
            ->orWhere('end_date', '<', now());
    }

    // check functions
    public function couponIsValid()
    {
        return $this->is_active == 1 && $this->time_used < $this->limit && $this->end_date > now();
    }

    public function status()
    {
        return $this->is_active == 1? 'Active' : 'Inactive';
    }
}
