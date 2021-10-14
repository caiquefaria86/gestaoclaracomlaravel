<?php

namespace App\Models;

use App\Models\Client;
use App\Models\Catalog;
use App\Models\Product;
use App\Models\Birthday;
use App\Models\Financial;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function catalogs()
    {
        return $this->hasMany(catalog::class);
    }


    public function products()
    {
        return $this->hasMany(Product::class);
    }


    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function orders_products()
    {
        return $this->hasMany(Order_Product::class, 'order_products', null, 'id');
    }

    public function financial()
    {
        return $this->hasMany(Financial::class);
    }

    public function financials()
    {
        return $this->belongsTo(Financial::class);
    }

    public function birthdays()
    {
        return $this->hasMany(Birthday::class);
    }

}
