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
        $customer_use = StatementTransaction::where('status', Config::get('custom.status.active'))
                                                ->where('customer_id', $customer->id)
                                                ->first();
        if ($customer_use!=null){
            return response()->json([
                'msg' => 'Customer uses on statement'
            ], 409);
        }
        return $customer->update(['status' => Config::get('custom.status.delete')]);
    }

    public function search_customer($search)
    {
        $customers = Customer::orderBy('created_at', 'DESC')
                            ->where('status', Config::get('custom.status.active'))
                            ->where('name', 'LIKE', '%' . $search . '%')
                            ->paginate(20);
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

}