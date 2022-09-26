<?php

namespace App\Models\Helpers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Range extends Model
{
    use HasFactory;

    protected $fillable = [
        'start',
        'end',
        'status'
    ];

    protected $attributes = ['status' => 1];
}
