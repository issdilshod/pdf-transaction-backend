<?php

namespace App\Http\Resources\Transactions;

use App\Http\Resources\Helpers\DescriptionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionCategoryToDescriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return new DescriptionResource($this->description);
    }
}
