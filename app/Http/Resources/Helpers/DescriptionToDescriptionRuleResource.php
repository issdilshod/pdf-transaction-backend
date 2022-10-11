<?php

namespace App\Http\Resources\Helpers;

use Illuminate\Http\Resources\Json\JsonResource;

class DescriptionToDescriptionRuleResource extends JsonResource
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
            'rule_id' => $this->description_rule_id,
            'description_rule' => new DescriptionRuleResource($this->description_rule),
            'value' => $this->value
        ];
    }
}
