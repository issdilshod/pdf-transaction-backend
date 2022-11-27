<?php

namespace App\Models\Partners;

use App\Models\Statements\StatementTransaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Customer extends Model
{
    use HasFactory;



    protected $fillable = [
        'name',
        'status'
    ];

    protected $attributes = ['status' => 1];

    public function use()
    {
        $uses = StatementTransaction::select('companies.id as company_id', 'companies.name as company_name', 'statement_periods.period', 'transaction_types.name as type_name', 'transaction_types.id as type_id')
                        ->groupBy('statement_transactions.type_id')
                        ->groupBy('statements.company_id')
                        ->join('statement_periods', 'statement_periods.id', '=', 'statement_transactions.period_id')
                        ->join('statements', 'statements.id', '=', 'statement_periods.statement_id')
                        ->join('companies', 'companies.id', '=', 'statements.company_id')
                        ->join('transaction_types', 'transaction_types.id', '=', 'statement_transactions.type_id')
                        ->where('statement_periods.status', Config::get('custom.status.active'))
                        ->where('statement_transactions.status', Config::get('custom.status.active'))
                        ->where('statement_transactions.customer_id', $this->id)
                        ->get();

        $one_use = [];
        foreach ($uses AS $key1 => $value1):
            // find company
            $exists = false; $exists_index = 0;
            foreach ($one_use AS $key2 => $value2):
                if ($one_use[$key2]['company_id']==$value1['company_id']){
                    $exists = true;
                    $exists_index = $key2;
                    break;
                }
            endforeach;

            // set
            if (!$exists){
                $one_use[] = [ 
                    'company_name' => $value1['company_name'], 
                    'company_id' => $value1['company_id'],
                    'types' => [
                        [
                            'type_id' => $value1['type_id'],
                            'type_name' => $value1['type_name'],
                            'period' => $value1['period']
                        ]
                    ]
                ];
            }else{
                $one_use[$exists_index]['types'][] = [
                    'type_id' => $value1['type_id'],
                    'type_name' => $value1['type_name'],
                    'period' => $value1['period']
                ];
            }
        endforeach;

        return $one_use;
    }

}
