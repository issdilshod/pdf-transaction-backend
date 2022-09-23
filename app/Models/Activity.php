<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'related_id',
        'device',
        'ip',
        'description',
        'changes',
        'type',
        'status'
    ];

    protected $attributes = ['status' => 1];

    /**
     * Relation to User
     * 
     * @return User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
