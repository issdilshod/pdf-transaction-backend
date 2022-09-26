<?php

namespace App\Http\Resources\Helpers;

use Illuminate\Http\Resources\Json\JsonResource;

class DescriptionResource extends JsonResource
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
            'description' => $this->description,
            'split' => $this->split,
            'description_rules' => DescriptionToDescriptionRuleResource::collection($this->description_rules)
        ];
    }
}
