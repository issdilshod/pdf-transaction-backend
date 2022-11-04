<?php

namespace App\Models\Helpers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdfTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'period',
        'name',
        'file_path',
        'file_name',
        'status'
    ];

    protected $attributes = ['status' => 1];
}
