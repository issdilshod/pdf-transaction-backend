<?php

namespace App\Models\Partners;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Config;

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
    public function address(): HasOne
    {
        return $this->hasOne(Address::class, 'related_id', 'id')
                        ->where('status', Config::get('custom.status.active'));
    }
}
