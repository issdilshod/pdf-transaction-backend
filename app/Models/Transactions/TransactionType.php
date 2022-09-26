<?php

namespace App\Models\Transactions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Support\Facades\Config;

class TransactionType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status'
    ];

    protected $attributes = ['status' => 1];

    public function transaction_categories(): HasOneOrMany
    {
        return $this->hasMany(TransactionCategory::class, 'transaction_type_id')
                        ->where('status', Config::get('custom.status.active'));
    }
}
