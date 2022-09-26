<?php

namespace App\Models\Statements;

use App\Models\Partners\Company;
use App\Models\Partners\Organization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Support\Facades\Config;

class Statement extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'organization_id',
        'name',
        'status'
    ];

    protected $attributes = ['status' => 1];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id')
                        ->where('status', Config::get('custom.status.active'));
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id')
                        ->where('status', Config::get('custom.status.active'));
    }

    public function periods(): HasOneOrMany
    {
        return $this->hasMany(StatementPeriod::class, 'statement_id')
                        ->where('status', Config::get('custom.status.active'));
    }
}
