<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use App\Models\Cart;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'country_id',
        'governorate_id',
        'city_id',
        'is_active',
        'phone'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function getStatusTranslated()
    {
        return $this->is_active == 1 ? __('dashboard.active') : __('dashboard.inactive');
    }

    // relation
    public function country()
    {
        return $this->belongsTo(Country::class , 'country_id');
    }
    public function  governorate()
    {
        return $this->belongsTo(Governorate::class , 'governorate_id');
    }
    public function  city()
    {
        return $this->belongsTo(City::class , 'city_id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class , 'user_id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class , 'user_id');
    }

    // user & cart
    public function cart()
    {
        return $this->hasOne(Cart::class , 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(ProductPreview::class , 'user_id');
    }


    // accessors
    public function getCreatedAtAttribute($value)
    {
        return date('d/m/Y H:i a', strtotime($value));
    }
    public function getEmailVerifiedAtAttribute($value)
    {
        return date('d/m/Y H:i a', strtotime($value));
    }
}