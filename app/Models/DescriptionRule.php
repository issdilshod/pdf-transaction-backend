<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DescriptionRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'value',
        'status'
    ];

    protected $attributes = ['status' => 1];
}
