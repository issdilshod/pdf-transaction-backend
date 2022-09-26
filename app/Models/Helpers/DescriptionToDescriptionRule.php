<?php

namespace App\Models\Helpers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Config;

class DescriptionToDescriptionRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'description_id',
        'description_rule_id',
        'value',
        'status'
    ];

    protected $attributes = ['status' => 1];

    /**
     * Retation to Description
     * 
     * @return Description
     */
    public function description(): BelongsTo
    {
        return $this->belongsTo(Description::class, 'description_id')
                        ->where('status', Config::get('custom.status.active'));
    }

    /**
     * Retation to Description Rule
     * 
     * @return DescriptionRule
     */
    public function description_rule(): BelongsTo
    {
        return $this->belongsTo(DescriptionRule::class, 'description_rule_id')
                        ->where('status', Config::get('custom.status.active'));
    }
}
