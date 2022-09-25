<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Config;

class Font extends Model
{
    use HasFactory;

    protected $fillable = [
        'font_group_id',
        'ascii',
        'unicode',
        'hex',
        'status'
    ];

    protected $attributes = ['status' => 1];

    /**
     * Relation to Font Group
     * 
     * @return FontGroup
     */
    public function font_group(): BelongsTo
    {
        return $this->belongsTo(FontGroup::class, 'font_group_id')
                        ->where('status', Config::get('custom.status.active'));
    }
}
