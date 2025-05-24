<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Setting extends Model
{
    use HasTranslations;

    public $timestamps = false;
    protected $table = 'settings';
    protected $fillable = [
        'site_name',
        'site_desc',
        'site_phone',
        'site_address',
        'site_email',
        'email_support',
        'logo',
        'favicon',
        'facebook_url',
        'twitter_url',
        'youtube_url',
        'meta_description',
        'meta_keywords',
        'promotion_video_url',
        'site_copyright'
    ];
    protected $translatable = [
        'site_name',
        'site_address',
        'site_desc',
        'meta_description',
    ];



    public function getLogoAttribute()
    {
        return 'uploads/settings/' . $this->attributes['logo'];
    }

    public function getFaviconAttribute()
    {
        return 'uploads/settings/' . $this->attributes['favicon'];
    }
}
