<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Config;

class UserAccessToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'token',
        'expires_at',
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
        return $this->belongsTo(User::class, 'user_id')
                        ->where('status', Config::get('custom.status.active'));
    }
}
