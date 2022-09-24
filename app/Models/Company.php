<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status'
    ];

    protected $attributes = ['status' => 1];

    /**
     * Relation to Address
     * 
     * @return Address
     */
    public function address(): HasOneOrMany
    {
        return $this->hasMany(Address::class, 'related_id', 'id');
    }
}
