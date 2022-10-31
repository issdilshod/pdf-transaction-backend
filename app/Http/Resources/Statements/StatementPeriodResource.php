<?php

namespace App\Http\Resources\Statements;

use Illuminate\Http\Resources\Json\JsonResource;

class StatementPeriodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'statement_id' => $this->statement_id,
            'period' => $this->period,
            'begining_balance' => $this->begining_balance,
            'ending_balance' => $this->ending_balance,
            'account_number' => $this->account_number,
            'item_previous_cycle' => $this->item_previous_cycle,
            'replacement' => json_decode($this->replacement),
            'transactions' => StatementTransactionResource::collection($this->transactions)
        ];
    }
}
