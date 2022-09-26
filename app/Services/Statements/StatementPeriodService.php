<?php

namespace App\Services\Statements;

use App\Http\Resources\Statements\StatementPeriodResource;
use App\Models\Statements\StatementPeriod;
use Illuminate\Support\Facades\Config;

class StatementPeriodService {

    public function create_statementPeriod($statementPeriod)
    {
        $exsist = StatementPeriod::where('status', Config::get('custom.status.active'))
                                    ->where('statement_id', $statementPeriod['statement_id'])
                                    ->where('period', $statementPeriod['period'])
                                    ->first();
        if ($exsist==null){
            $created = StatementPeriod::create($statementPeriod);
            return new StatementPeriodResource($created);
        }
        return response()->json([
            'error' => 'Data exsist.'
        ], 409);
    }

    public function update_statementPeriod($update, StatementPeriod $statementPeriod)
    {
        
    }

    public function delete_statementPeriod(StatementPeriod $statementPeriod)
    {
        $statementPeriod->update(['status' => Config::get('custom.status.delete')]);
    }
}