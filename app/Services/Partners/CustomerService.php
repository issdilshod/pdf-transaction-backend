<?php

namespace App\Services\Partners;

use App\Http\Resources\Partners\CustomerResource;
use App\Models\Partners\Customer;
use App\Models\Statements\StatementTransaction;
use Illuminate\Support\Facades\Config;

class CustomerService {

    public function get_customers()
    {
        $customers = Customer::orderBy('created_at', 'DESC')
                                ->where('status', Config::get('custom.status.active'))
                                ->paginate(20);

        $customers = $this->where_use($customers);

        return CustomerResource::collection($customers);
    }

    public function get_customer(Customer $customer)
    {
        $customer = new CustomerResource($customer);
        return $customer;
    }

    public function create_customer($customer)
    {
        $exsist = Customer::where('status', Config::get('custom.status.active'))
                        ->where('name', $customer['name'])
                        ->first();
        if ($exsist==null){
            $created = Customer::create($customer);
            return new CustomerResource($created);
        }
        return response()->json([
            'error' => 'Data exsist.'
        ], 409);
    }

    public function update_customer($update, Customer $customer)
    {
        $exsist = Customer::where('status', Config::get('custom.status.active'))
                        ->where('name', $update['name'])
                        ->where('id', '!=', $customer->id)
                        ->first();
        if ($exsist==null){
            $customer->update($update);
            return new CustomerResource($customer);
        }
        return response()->json([
            'error' => 'Data exsist.'
        ], 409);
    }

    public function delete_customer(Customer $customer)
    {
        $customer->update(['status' => Config::get('custom.status.delete')]);
    }

    public function search_customer($search)
    {
        $customers = Customer::orderBy('created_at', 'DESC')
                            ->where('status', Config::get('custom.status.active'))
                            ->where('name', 'LIKE', '%' . $search . '%')
                            ->paginate(20);

        $customers = $this->where_use($customers);

        return CustomerResource::collection($customers);
    }

    public function import_customer($object)
    {
        $tmpArray = [];
        // mapping
        foreach ($object['data'] AS $key => $value):
            $tmpArray[$key] = [
                'name' => $value[$object['mapping']['name']], 
            ];
        endforeach;

        // recording
        $counter = ['recorded_count' => 0, 'exsist_count' => 0];
        foreach ($tmpArray AS $key => $value):
            $exsist = Customer::where('status', Config::get('custom.status.active'))
                                ->where('name', $value['name'])
                                ->first();
            if ($exsist==null){
                $customer = Customer::create($value);
                $counter['recorded_count']++;
            }else{
                $counter['exsist_count']++;
            }
        endforeach;
        if ($counter['recorded_count']>0){
            return $counter;
        }
        return response()->json([
            'error' => 'Data exsist.'
        ], 409);
    }

    public function get_count()
    {
        $customers = Customer::where('status', Config::get('custom.status.active'))
                                ->get();
        return count($customers);
    }

    private function where_use($customers)
    {
        foreach ($customers AS $key => $value):
            $uses = StatementTransaction::select('companies.id as company_id', 'companies.name as company_name', 'statement_periods.period', 'transaction_types.name as type_name', 'transaction_types.id as type_id')
                                            ->groupBy('statement_transactions.type_id')
                                            ->groupBy('statements.company_id')
                                            ->join('statement_periods', 'statement_periods.id', '=', 'statement_transactions.period_id')
                                            ->join('statements', 'statements.id', '=', 'statement_periods.statement_id')
                                            ->join('companies', 'companies.id', '=', 'statements.company_id')
                                            ->join('transaction_types', 'transaction_types.id', '=', 'statement_transactions.type_id')
                                            ->where('statement_periods.status', Config::get('custom.status.active'))
                                            ->where('statement_transactions.status', Config::get('custom.status.active'))
                                            ->where('statement_transactions.customer_id', $value['id'])
                                            ->get();

            // order by company
            $uses = $uses->toArray();
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
            
            $customers[$key]['use'] = $one_use;
        endforeach;

        return $customers;
    }
}