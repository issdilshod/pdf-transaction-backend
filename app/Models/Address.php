<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Config;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'related_id',
        'address_line1',
        'address_line2',
        'state_id',
        'city',
        'postal',
        'status'
    ];

    protected $attributes = ['status' => 1];

    /**
     * Relation to State
     * 
     * @return State
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id', 'id')
                        ->where('status', Config::get('custom.status.active'));
    }
}
