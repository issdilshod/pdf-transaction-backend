<?php

namespace App\Models\Helpers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdfImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'period',
        'status'
    ];

    protected $attributes = ['status' => 1];
}
