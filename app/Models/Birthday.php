<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Birthday extends Model
{
    use HasFactory;

    protected $filable = [
        'user_id','name','relationship','birthday'
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
