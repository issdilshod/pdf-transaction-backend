<?php

namespace App\Models\Helpers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Support\Facades\Config;

class Description extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'split',
        'status'
    ];

    protected $attributes = ['status' => 1];

    /**
     * Relation to DescriptionToDescriptionRule
     * 
     * @return Array(DescriptionToDescriptionRule)
     */
    public function description_rules(): HasOneOrMany
    {
        return $this->hasMany(DescriptionToDescriptionRule::class, 'description_id')
                        ->where('status', Config::get('custom.status.active'));
    }

}
