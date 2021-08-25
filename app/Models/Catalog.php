<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Catalog extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_product',
        'name',
        'unitaryValue',
        'finalValue'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
