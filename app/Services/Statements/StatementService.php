<?php

namespace App\Services\Statements;

use App\Http\Resources\Statements\StatementResource;
use App\Models\Statements\Statement;
use App\Models\Statements\StatementPeriod;
use App\Models\Statements\StatementTransaction;
use App\Models\Statements\StatementTransactionDescription;
use Illuminate\Support\Facades\Config;

class StatementService {

    private $statementPeriodService;
    private $statementTransactionService;
    private $statementTransactionDescriptionService;

    public function __construct()
    {
        $this->statementPeriodService = new StatementPeriodService();
        $this->statementTransactionService = new StatementTransactionService();
        $this->statementTransactionDescriptionService = new StatementTransactionDescriptionService();
    }

    public function get_statements()
    {
        $statements = Statement::orderBy('created_at', 'DESC')
                                    ->where('status', Config::get('custom.status.active'))
                                    ->paginate(20);
        return StatementResource::collection($statements);
    }

    public function get_statement(Statement $statement)
    {
        $statement = new StatementResource($statement);
        return $statement;
    }

    public function create_statement($statement)
    {
        $created = Statement::create($statement);

        $this->periods_transactions($statement, $created);

        return new StatementResource($created);
    }

    public function update_statement($update, Statement $statement)
    {
        $statement->update($update);

        $this->periods_transactions($update, $statement);

        return new StatementResource($statement);
    }

    public function delete_statement(Statement $statement)
    {
        $statement->update(['status' => Config::get('custom.status.delete')]);

        // periods
        $periods = StatementPeriod::where('status', Config::get('custom.status.active'))
                                    ->where('statement_id', $statement->id)
                                    ->get();
        StatementPeriod::where('status', Config::get('custom.status.active'))
                        ->where('statement_id', $statement->id)
                        ->update(['status' => Config::get('custom.status.delete')]);
        foreach ($periods AS $key => $value):
            $transactions = StatementTransaction::where('status', Config::get('custom.status.active'))
                                                    ->where('period_id', $value['id'])
                                                    ->get();
            StatementTransaction::where('status', Config::get('custom.status.active'))
                                ->where('period_id', $value['id'])
                                ->update(['status' => Config::get('custom.status.delete')]);
            // transactions
            foreach ($transactions AS $key1 => $value1):

                // descriptions
                StatementTransactionDescription::where('status', Config::get('custom.status.active'))
                                                ->where('transaction_id', $value1['id'])
                                                ->update(['status' => Config::get('custom.status.delete')]);
            endforeach;

        endforeach;
    }

    public function get_count()
    {
        $statements = Statement::where('status', Config::get('custom.status.active'))
                                ->get();
        return count($statements);
    }

    public function get_last($company_id, $last_period)
    {
        $last = StatementPeriod::select('ending_balance')
                                ->join('statements', 'statements.id', '=', 'statement_periods.statement_id')
                                ->where('statement_periods.period', $last_period)
                                ->where('statements.company_id', $company_id)
                                ->first();
        if ($last!=null){
            return $last;
        }
        return response()->json([
            'msg' => 'Not Found.'
        ], 404);
    }

    public function trash_statement($id)
    {
        //
    }

    private function periods_transactions($entity, $statement)
    {
        // periods
        $this->statementPeriodService->delete($statement->id);
        foreach ($entity['periods'] AS $key => $value):
            $value['statement_id'] = $statement->id;

            $period = $this->statementPeriodService->save($value);

            // transactions
            $this->statementTransactionService->delete($period->id);
            foreach ($value['transactions'] AS $key1 => $value1):
                $value1['period_id'] = $period->id;
                
                $transaction = $this->statementTransactionService->save($value1);

                // description
                $this->statementTransactionDescriptionService->delete($transaction->id);
                foreach ($value1['descriptions'] AS $key2 => $value2):
                    if (isset($value2['description']['id'])){ // if choosed description
                        $description = [
                            'transaction_id' => $transaction->id,
                            'description_id' => $value2['description']['id'],
                            'value' => $value2['value']
                        ];
                        $description = $this->statementTransactionDescriptionService->save($description);
                    }
                endforeach;
                
            endforeach;

        endforeach;
    }
}