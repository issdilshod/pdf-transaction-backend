<?php

namespace App\Http\Resources\Statements;

use App\Http\Resources\Partners\CustomerResource;
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
            'period_id' => $this->period_id,
            'type_id' => $this->type_id,
            'category_id' => $this->category_id,
            'customer_id' => $this->customer_id,
            'customer' => new CustomerResource($this->customer),
            'sender_id' => $this->sender_id,
            'sender' => $this->sender,
            'date' => $this->date,
            'amount' => $this->amount,
            'amount_min' => $this->amount_min,
            'amount_max' => $this->amount_max,
            'descriptions' => StatementTransactionDescriptionResource::collection($this->descriptions)
        ];
    }
}
