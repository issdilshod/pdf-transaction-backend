<?php

namespace App\Models\Statements;

use App\Models\Partners\Customer;
use App\Models\Partners\Sender;
use App\Models\Transactions\TransactionCategory;
use App\Models\Transactions\TransactionType;
use App\Services\Partners\CustomerService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Config;

class StatementTransaction extends Model
{
    use HasFactory;

    private $customerService;

    public function __construct()
    {
        $this->customerService = new CustomerService();
    }

    protected $fillable = [
        'period_id',
        'type_id',
        'category_id',
        'customer_id',
        'sender_id',
        'date',
        'amount',
        'amount_min',
        'amount_max',
        'status'
    ];

    protected $attributes = ['status' => 1];

    public function period(): BelongsTo
    {
        return $this->belongsTo(StatementPeriod::class, 'period_id')
                        ->where('status', Config::get('custom.status.active'));
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(TransactionType::class, 'type_id')
                        ->where('status', Config::get('custom.status.active'));
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(TransactionCategory::class, 'category_id')
                        ->where('status', Config::get('custom.status.active'));
    }

    public function customer(): BelongsTo
    {
        $customer = $this->belongsTo(Customer::class, 'customer_id')
                        ->where('status', Config::get('custom.status.active'));

        $uses = $this->customerService->where_use_query($customer->toArray());
        $customer->use = $this->customerService->where_use_set($uses);

        return $customer;
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(Sender::class, 'sender_id')
                        ->where('status', Config::get('custom.status.active'));
    }

    public function descriptions(): HasMany
    {
        return $this->hasMany(StatementTransactionDescription::class, 'transaction_id')
                        ->where('status', Config::get('custom.status.active'));
    }
}
