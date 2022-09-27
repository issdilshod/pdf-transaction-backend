<?php

namespace App\Services\Statements;

use App\Models\Statements\StatementTransaction;
use Illuminate\Support\Facades\Config;

class StatementTransactionService {

    public function create_statementTransaction($statementTransaction)
    {
        StatementTransaction::create($statementTransaction);
    }

    public function update_statementTransaction($statementTransaction)
    {
        $statementTransaction_orgin = StatementTransaction::where('status', Config::get('custom.status.active'))
                                                            ->where('period_id', $statementTransaction['period_id'])
                                                            ->where('type_id', $statementTransaction['type_id'])
                                                            ->where('date', $statementTransaction['date'])
                                                            ->where('amount', $statementTransaction['amount'])
                                                            ->first();
        if ($statementTransaction_orgin==null){
            $this->create_statementTransaction($statementTransaction);
        }else{
            $statementTransaction_orgin->update($statementTransaction);
        }
    }

    public function delete_statementTransaction($statementTransaction_id)
    {
        $statementTransaction = StatementTransaction::where('id', $statementTransaction_id);
        $statementTransaction->update(['status' => Config::get('custom.status.delete')]);
    }

}