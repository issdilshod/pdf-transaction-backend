<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Config;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'password',
        'first_name',
        'last_name',
        'role',
        'status'
    ];

    protected $attributes = ['status' => 1];

    /**
     * Relation to UserAccessToken
     * 
     * @return Array(UserAccessToken)
     */
    public function user_access_tokens(): HasMany
    {
        return $this->hasMany(UserAccessToken::class)
                        ->where('status', Config::get('custom.status.active'));
    }

    /**
     * Relation to Activity
     * 
     * @return Array(Activity)
     */
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class)
                        ->where('status', Config::get('custom.status.active'));
    }

}
