<?php

namespace App\Models\Helpers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Config;

class FontGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status'
    ];

    protected $attributes = ['status' => 1];

    /**
     * Relation to Font
     * 
     * @return Array(Font)
     */
    public function fonts(): HasMany
    {
        return $this->hasMany(Font::class, 'font_group_id')
                        ->where('status', Config::get('custom.status.active'));
    }
}
