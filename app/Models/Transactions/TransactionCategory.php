<?php

namespace App\Models\Transactions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Support\Facades\Config;

class TransactionCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_type_id',
        'name',
        'offset',
        'customer',
        'sender',
        'status'
    ];

    protected $attributes = ['status' => 1];

    public function transaction_type(): BelongsTo
    {
        return $this->belongsTo(TransactionType::class, 'transaction_type_id')
                        ->where('status', Config::get('custom.status.active'));
    }

    public function descriptions(): HasOneOrMany
    {
        return $this->hasMany(TransactionCategoryToDescription::class, 'category_id')
                        ->where('status', Config::get('custom.status.active'));

    }
}
