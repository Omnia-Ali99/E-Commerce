<?php

namespace App\Models;

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, HasTranslations;
    use Sluggable;

    public $translatable = ['name', 'desc', 'small_desc'];
    public $guarded = [];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    // relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function productPreviews()
    {
        return $this->hasMany(ProductPreview::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags', 'product_id', 'tag_id');
    }
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // functions
    public function getStatusTranslated()
    {
        return $this->status == 1 ? __('dashboard.active') : __('dashboard.inactive');
    }
    public function hasVariantsTranslated()
    {
        return $this->has_variants == 1 ? __('dashboard.yes_variants') : __('dashboard.no_variants');
    }
    public function isSimple()
    {
        return !$this->has_variants;
    }
    // get price after discount
    public function getPriceAfterDiscount()
    {
        if ($this->has_discount) {
            return $this->price - $this->discount;
        }
        return $this->price;
    }

    // accessores

    public function getCreatedAtAttribute($value)
    {
        if(request()->wantsJson()){
            return $value;
        }
        return date('d/m/Y H:i a', strtotime($value));

    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d/m/Y H:i a', strtotime($value));
    }

    public function PriceAttribute()
    {
        return $this->has_variants == 0 ? number_format($this->price, 2) : __("dashboard.has_variants");
    }
    public function quantityAttribute()
    {
        return $this->has_variants == 0 ? $this->quantity : __("dashboard.has_variants");
    }

    public function discountPercentage()
    {
        // Skip if product has variants or discount is null/zero
        if ($this->variants()->exists() || !$this->discount || $this->price == 0) {
            return '🔥';
        }

        // Calculate percentage
        return round(($this->discount / $this->price) * 100, 2).'%';
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    public function scopeInactive($query)
    {
        return $query->where('status', 0);
    }
}