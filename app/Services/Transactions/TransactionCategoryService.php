<?php

namespace App\Services\Transactions;

use App\Http\Resources\Transactions\TransactionCategoryResource;
use App\Models\Transactions\TransactionCategory;
use App\Models\Transactions\TransactionCategoryToDescription;
use Illuminate\Support\Facades\Config;

class TransactionCategoryService {

    public function get_transactionCategories()
    {
        $transactionCategories = TransactionCategory::orderBy('transaction_type_id', 'ASC')
                                                    ->orderBy('name', 'ASC')
                                                    ->where('status', Config::get('custom.status.active'))
                                                    ->get();
        return TransactionCategoryResource::collection($transactionCategories);
    }

    public function get_transactionCategory(TransactionCategory $transactionCategory)
    {
        $transactionCategory = new TransactionCategoryResource($transactionCategory);
        return $transactionCategory;
    }

    public function create_transactionCategory($transactionCategory)
    {
        $exsist = TransactionCategory::where('status', Config::get('custom.status.active'))
                                        ->where('transaction_type_id', $transactionCategory['transaction_type_id'])
                                        ->where('name', $transactionCategory['name'])
                                        ->first();
        if ($exsist==null){
            $created = TransactionCategory::create($transactionCategory);
            // add description if exsist
            if (isset($transactionCategory['descriptions'])){
                foreach ($transactionCategory['descriptions'] AS $key => $value):
                    TransactionCategoryToDescription::create([
                        'category_id' => $created->id,
                        'description_id' => $value['id']
                    ]);
                endforeach;
            }
            return new TransactionCategoryResource($created);
        }
        return response()->json([
            'error' => 'Data exsist.'
        ], 409);
    }

    public function update_transactionCategory($update, TransactionCategory $transactionCategory)
    {
        $exsist = TransactionCategory::where('status', Config::get('custom.status.active'))
                                        ->where('transaction_type_id', $update['transaction_type_id'])
                                        ->where('name', $update['name'])
                                        ->where('id', '!=', $transactionCategory->id)
                                        ->first();
        if ($exsist==null){
            $transactionCategory->update($update);
            // add description if exsist
            if (isset($update['descriptions'])){
                TransactionCategoryToDescription::where('category_id', $transactionCategory->id)->update(['status' => Config::get('custom.status.delete')]);
                foreach ($update['descriptions'] AS $key => $value):
                    TransactionCategoryToDescription::create([
                        'category_id' => $transactionCategory->id,
                        'description_id' => $value['id']
                    ]);
                endforeach;
            }
            return new TransactionCategoryResource($transactionCategory);
        }
        return response()->json([
            'error' => 'Data exsist.'
        ], 409);
    }

    public function delete_transactionCategory(TransactionCategory $transactionCategory)
    {
        $transactionCategory->update(['status' => Config::get('custom.status.delete')]);
    }
}