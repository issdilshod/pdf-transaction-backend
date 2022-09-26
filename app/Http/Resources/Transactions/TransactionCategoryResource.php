<?php

namespace App\Http\Resources\Transactions;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionCategoryResource extends JsonResource
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
            'name' => $this->name,
            'offset' => $this->offset,
            'customer' => $this->customer,
            'sender' => $this->sender,
            'transaction_type_id' => $this->transaction_type_id,
            'descriptions' => TransactionCategoryToDescriptionResource::collection($this->descriptions)
        ];
    }
}
