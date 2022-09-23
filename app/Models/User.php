<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        return $this->hasMany(UserAccessToken::class);
    }

    /**
     * Relation to Activity
     * 
     * @return Array(Activity)
     */
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

}
