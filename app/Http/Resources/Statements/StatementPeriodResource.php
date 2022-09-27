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
            'transactions' => StatementTransactionResource::collection($this->transactions)
        ];
    }
}
