<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'page',
        'start_offset',
        'end_offset',
        'status'
    ];

    protected $attributes = ['status' => 1];
}
