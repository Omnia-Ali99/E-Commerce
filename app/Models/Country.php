<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Spatie\Translatable\HasTranslations;

class Country extends Model
{
    use HasTranslations;

    protected $fillable = ['name' , 'phone_code' , 'is_active' , 'flag_code'];

    public $timestamps = false;

    public $translatable = ['name'];

    public function governorates()
    {
        return $this->hasMany(Governorate::class , 'country_id');
    }
    public function users()
    {
        return $this->hasMany(User::class , 'country_id');
    }
    public function getIsActiveAttribute($value)
    {
        if(Config::get('app.locale') == 'ar'){
            return $value == 1 ? 'مفعل' : 'غير مفعل';

        }
        return $value == 1 ? 'Active' : 'Inactive';
    }


}
