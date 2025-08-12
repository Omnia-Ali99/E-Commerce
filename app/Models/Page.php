<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasTranslations;
    protected $fillable = ['title','slug','content','image'];
    protected $translatable = ['title','content'];



    public function getCreatedAtAttribute()
    {
        return date('d-m-Y h:i a',strtotime($this->attributes['created_at']));
    }

    // public function getImageAttribute($value)
    // {
    //     return asset('uploads/pages/'.$value);
    // }



}