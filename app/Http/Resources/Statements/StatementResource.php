<?php

namespace App\Http\Resources\Statements;

use App\Http\Resources\Partners\CompanyResource;
use App\Http\Resources\Partners\OrganizationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class StatementResource extends JsonResource
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
            'company' => new CompanyResource($this->company),
            'organization' => new OrganizationResource($this->organization),
            'name' => $this->name,
            'periods' => StatementPeriodResource::collection($this->periods),
            'created_at' => $this->created_at
        ];
    }
}
