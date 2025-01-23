<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Role extends Model
{
    protected $fillable =['role','permession','created_at','updated_at'];

    use HasTranslations;

    public $translatable = ['role'];

    public function getpermessionAttribute($value)
    {
        return json_decode($value);
    }
    public function admins()
    {
        return $this->hasMany(Admin::class , 'role_id');
    }

    
}
