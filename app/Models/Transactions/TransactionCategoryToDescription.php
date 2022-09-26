<?php

namespace App\Models\Transactions;

use App\Models\Helpers\Description;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Config;

class TransactionCategoryToDescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'description_id',
        'status'
    ];

    protected $attributes = ['status' => 1];

    public function category(): BelongsTo
    {
        return $this->belongsTo(TransactionCategory::class, 'category_id')
                        ->where('status', Config::get('custom.status.active'));
    }

    public function description(): BelongsTo
    {
        return $this->belongsTo(Description::class, 'description_id')
                        ->where('status', Config::get('custom.status.active'));
    }
}
