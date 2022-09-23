<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'password',
        'first_name',
        'last_name',
        'role',
        'status'
    ];

    protected $attributes = ['status' => 1];

}
