<?php

namespace App\Models;

use App\Models\User;
use App\Models\Financial;
use App\Models\OrderProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nickname',
        'celphone',
        'email',
        'street',
        'number',
        'district',
        'city'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function financials()
    {
        return $this->hasMany(Financial::class);
    }
    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
