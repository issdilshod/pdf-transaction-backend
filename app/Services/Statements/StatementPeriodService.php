<?php

namespace App\Services\Statements;

use App\Http\Resources\Statements\StatementPeriodResource;
use App\Models\Statements\StatementPeriod;
use Illuminate\Support\Facades\Config;

class StatementPeriodService {

    private $statementTransactionService;

    public function __construct()
    {
        $this->statementTransactionService = new StatementTransactionService();
    }

    public function create_statementPeriod($statementPeriod)
    {
        $exsist = StatementPeriod::where('status', Config::get('custom.status.active'))
                                    ->where('statement_id', $statementPeriod['statement_id'])
                                    ->where('period', $statementPeriod['period'])
                                    ->first();
        if ($exsist==null){
            $created = StatementPeriod::create($statementPeriod);
            // create transactions if exsist
            if (isset($statementPeriod['transactions'])){
                foreach ($statementPeriod['transactions'] AS $key => $value):
                    $value['period_id'] = $created->id;
                    $this->statementTransactionService->create_statementTransaction($value);
                endforeach;
            }
            return new StatementPeriodResource($created);
        }
        return response()->json([
            'error' => 'Data exsist.'
        ], 409);
    }

    public function update_statementPeriod($update, StatementPeriod $statementPeriod)
    {
        $exsist = StatementPeriod::where('status', Config::get('custom.status.active'))
                                    ->where('statement_id', $update['statement_id'])
                                    ->where('period', $update['period'])
                                    ->where('id', '!=', $statementPeriod['id'])
                                    ->first();
        if ($exsist==null){
            $statementPeriod->update($update);
            // create transactions if exsist
            if (isset($update['transactions'])){
                foreach ($update['transactions'] AS $key => $value):
                    $value['period_id'] = $statementPeriod->id;
                    $this->statementTransactionService->update_statementTransaction($value);
                endforeach;
            }
            // delete transactions if exsist
            if (isset($update['transactions_to_delete'])){
                foreach ($update['transactions_to_delete'] AS $key => $value):
                    $this->statementTransactionService->delete_statementTransaction($value);
                endforeach;
            }
            return new StatementPeriodResource($statementPeriod);
        }
        return response()->json([
            'error' => 'Data exsist.'
        ], 409);
    }

    public function delete_statementPeriod(StatementPeriod $statementPeriod)
    {
        $statementPeriod->update(['status' => Config::get('custom.status.delete')]);
    }
}