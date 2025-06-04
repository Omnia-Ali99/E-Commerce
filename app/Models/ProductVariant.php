<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = ['product_id', 'stock', 'price'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function VariantAttributes()
    {
        return $this->hasMany(VariantAttribute::class);
    }
}
