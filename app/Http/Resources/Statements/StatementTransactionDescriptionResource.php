<?php

namespace App\Http\Resources\Statements;

use App\Http\Resources\Helpers\DescriptionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class StatementTransactionDescriptionResource extends JsonResource
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
            'description' => new DescriptionResource($this->description),
            'value' => $this->value
        ];
    }
}
