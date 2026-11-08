<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPreview extends Model
{
    protected $fillable = ['comment', 'user_id', 'product_id'];
    // relations
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
