<?php

namespace App\Services\Statements;

use App\Models\Statements\StatementTransactionDescription;
use Illuminate\Support\Facades\Config;

class StatementTransactionDescriptionService {

    public function save($entity)
    {
        $description = StatementTransactionDescription::where('transaction_id', $entity['transaction_id'])
                                                        ->where('description_id', $entity['description_id'])
                                                        ->first();
        if ($description==null){
            $description = StatementTransactionDescription::create($entity);
        }else{
            $entity['status'] = Config::get('custom.status.active');
            $description->update($entity);
        }
        return $description;
    }

    public function delete($transaction_id)
    {
        StatementTransactionDescription::where('transaction_id', $transaction_id)->update(['status' => Config::get('custom.status.delete')]);
    }
}