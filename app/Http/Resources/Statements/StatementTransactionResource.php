<?php

namespace App\Http\Resources\Statements;

use Illuminate\Http\Resources\Json\JsonResource;

class StatementTransactionResource extends JsonResource
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
            'period_id' => $this->period,
            'type' => $this->type,
            'category' => $this->category,
            'customer' => $this->customer,
            'sender' => $this->sender,
            'date' => $this->date,
            'amount' => $this->amount,
            'amount_min' => $this->amount_min,
            'amount_max' => $this->amount_max
        ];
    }
}
