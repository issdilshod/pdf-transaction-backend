<?php

namespace App\Services;

use App\Http\Resources\CustomerResource;
use App\Models\Customer;
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
        $customer->update(['status' => Config::get('custom.status.delete')]);
    }

    public function search_customer($search)
    {
        $customers = Customer::orderBy('created_at', 'DESC')
                            ->where('status', Config::get('custom.status.active'))
                            ->where('name', 'LIKE', '%' . $search . '%')
                            ->get();
        return CustomerResource::collection($customers);
    }
}