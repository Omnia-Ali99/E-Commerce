<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class AttributeValue extends Model
{
    use HasTranslations;

    protected $table = 'attribute_values';
    public $timestamps = false;
    protected $fillable = [
        'attribute_id',
        'value',
    ];
    public $translatable = ['value'];


    // relationships
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
