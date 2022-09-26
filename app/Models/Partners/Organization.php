<?php

namespace App\Models\Partners;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status'
    ];

    protected $attributes = ['status' => 1];
}
