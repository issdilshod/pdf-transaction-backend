<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $fillable = [
        'short_name',
        'full_name',
        'status'
    ];

    protected $attributes = ['status' => 1];
}
