<?php

namespace App\Services\Statements;

use App\Models\Statements\StatementPeriod;
use Illuminate\Support\Facades\Config;

class StatementPeriodService {

    public function save($entity)
    {
        $period = StatementPeriod::where('statement_id', $entity['statement_id'])
                                    ->where('period', $entity['period'])
                                    ->first();
        $entity['replacement'] = json_encode($entity['replacement']);
        $entity['begining_balance'] = (float)$entity['begining_balance'];
        $entity['ending_balance'] = (float)$entity['ending_balance'];
        if ($period==null){
            $period = StatementPeriod::create($entity);
        }else{
            $entity['status'] = Config::get('custom.status.active');
            $period->update($entity);
        }
        return $period;
    }

    public function delete($statement_id)
    {
        StatementPeriod::where('statement_id', $statement_id)->update(['status' => Config::get('custom.status.delete')]);
    }
}