<?php

namespace App\Models\Statements;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Config;

class StatementPeriod extends Model
{
    use HasFactory;

    protected $fillable = [
        'statement_id',
        'period',
        'status'
    ];

    protected $attributes = ['status' => 1];

    public function statement(): BelongsTo
    {
        return $this->belongsTo(Statement::class, 'statement_id')
                        ->where('status', Config::get('custom.status.active'));
    }
}
