<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{ 
    protected $fillable = ['user_id', 'product_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function scopeWithProductDetails($query)
    {
        return $query->with(['product' => function ($query) {
            $query->select('id', 'name', 'price', 'has_variants')
                ->with(['images' => function ($query) {
                    $query->select('id', 'product_id', 'file_name')
                        ->limit(1);
                }, 'variants' => function ($query) {
                    $query->select('id', 'product_id', 'price')
                        ->orderBy('price', 'asc')
                        ->limit(1);
                }]);
        }])->select('id', 'product_id', 'user_id');
    }
}
