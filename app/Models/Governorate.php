<?php

namespace App\Models;

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Governorate extends Model
{
    use HasTranslations;

    protected $fillable = ['name' ,'is_active','country_id'];

    public $timestamps = false;

    public $translatable = ['name'];

    public function country()
    {
        return $this->belongsTo(Country::class , 'country_id');
    }
    public function users()
    {
        return $this->hasMany(User::class , 'governorate_id');
    }

    public function cities()
    {
        return $this->hasMany(City::class , 'governorate_id');
    }

    public function shippingPrice()
    {
        return $this->hasOne(ShippingGovernorate::class , 'governorate_id');
    }
    public function getIsActiveAttribute($value)
    {
        if(Config::get('app.locale') == 'ar'){
            return $value == 1 ? 'مفعل' : 'غير مفعل';

        }
        return $value == 1 ? 'Active' : 'Inactive';
    }
}
