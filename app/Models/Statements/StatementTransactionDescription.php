<?php

namespace App\Models\Statements;

use App\Models\Helpers\Description;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Config;

class StatementTransactionDescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'description_id',
        'value',
        'status'
    ];

    protected $attributes = ['status' => 1];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(StatementTransaction::class, 'transaction_id')
                        ->where('status', Config::get('custom.status.active'));
    }

    public function description(): BelongsTo
    {
        return $this->belongsTo(Description::class, 'description_id')
                        ->where('status', Config::get('custom.status.active'));
    }
}
