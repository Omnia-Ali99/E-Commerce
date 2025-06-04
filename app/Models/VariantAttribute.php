<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariantAttribute extends Model
{
     protected $guarded = [];

    public function ProductVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
    public function attributeValue()
    {
        return $this->belongsTo(AttributeValue::class);
    }
}
