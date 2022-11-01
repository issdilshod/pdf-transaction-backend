<?php

namespace App\Models\Statements;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Support\Facades\Config;

class StatementPeriod extends Model
{
    use HasFactory;

    protected $fillable = [
        'statement_id',
        'period',
        'begining_balance',
        'ending_balance',
        'account_number',
        'item_previous_cycle',
        'replacement',
        'status'
    ];

    protected $attributes = ['status' => 1];

    public function statement(): BelongsTo
    {
        return $this->belongsTo(Statement::class, 'statement_id')
                        ->where('status', Config::get('custom.status.active'));
    }

    public function transactions(): HasOneOrMany
    {
        return $this->hasMany(StatementTransaction::class, 'period_id')
                        ->orderBy('type_id', 'ASC')
                        ->orderBy('date', 'ASC')
                        ->where('status', Config::get('custom.status.active'));
    }
}
