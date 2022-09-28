<?php

namespace App\Services\Transactions;

use App\Http\Resources\Transactions\TransactionTypeResource;
use App\Models\Transactions\TransactionType;
use Illuminate\Support\Facades\Config;

class TransactionTypeService {

    public function get_transactionTypes()
    {
        $transactionTypes = TransactionType::orderBy('name', 'ASC')
                                        ->where('status', Config::get('custom.status.active'))
                                        ->get();
        return TransactionTypeResource::collection($transactionTypes);
    }

    public function get_transactionType(TransactionType $transactionType)
    {
        $transactionType = new TransactionTypeResource($transactionType);
        return $transactionType;
    }

    public function create_transactionType($transactionType)
    {
        $exsist = TransactionType::where('status', Config::get('custom.status.active'))
                                    ->where('name', $transactionType['name'])
                                    ->first();
        if ($exsist==null){
            $created = TransactionType::create($transactionType);
            return new TransactionTypeResource($created);
        }
        return response()->json([
            'error' => 'Data exsist.'
        ], 409);
    }

    public function update_transactionType($update, TransactionType $transactionType)
    {
        $exsist = TransactionType::where('status', Config::get('custom.status.active'))
                                ->where('name', $update['name'])
                                ->where('id', '!=', $transactionType->id)
                                ->first();
        if ($exsist==null){
            $transactionType->update($update);
            return new TransactionTypeResource($transactionType);
        }
        return response()->json([
            'error' => 'Data exsist.'
        ], 409);
    }

    public function delete_transactionType(TransactionType $transactionType)
    {
        $transactionType->update(['status' => Config::get('custom.status.delete')]);
    }
}