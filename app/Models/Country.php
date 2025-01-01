<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['name' , 'phone_code' , 'is_active' , 'flag_code'];

    public $timestamps = false;
}
