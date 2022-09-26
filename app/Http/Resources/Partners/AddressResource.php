<?php

namespace App\Http\Resources\Partners;

use App\Http\Resources\Helpers\StateResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'address_line1' => $this->address_line1,
            'address_line2' => $this->address_line2,
            'state' => new StateResource($this->state),
            'city' => $this->city,
            'postal' => $this->postal
        ];
    }
}
