<?php

namespace App\Services\Statements;

use App\Models\Statements\StatementTransaction;
use Illuminate\Support\Facades\Config;

class StatementTransactionService {

    public function save($entity)
    {
        $transaction = StatementTransaction::where('period_id', $entity['period_id'])
                                            ->where('type_id', $entity['type_id'])
                                            ->where('date', $entity['date'])
                                            ->first();
        if ($transaction==null){
            $transaction = StatementTransaction::create($entity);
        }else{
            $entity['status'] = Config::get('custom.status.active');
            $transaction->update($entity);
        }
        return $transaction;
    }

    public function delete($period_id)
    {
        StatementTransaction::where('period_id', $period_id)->update(['status' => Config::get('custom.status.delete')]);
    }

}