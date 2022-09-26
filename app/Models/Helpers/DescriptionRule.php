<?php

namespace App\Models\Helpers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Support\Facades\Config;

class DescriptionRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'value',
        'status'
    ];

    protected $attributes = ['status' => 1];

    /**
     * Relation to DescriptionToDescriptionRule
     * 
     * @return Array(DescriptionToDescriptionRule)
     */
    public function description(): HasOneOrMany
    {
        return $this->hasMany(DescriptionToDescriptionRule::class, 'description_rule_id')
                        ->where('status', Config::get('custom.status.active'));
    }
}
