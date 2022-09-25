<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FontResource extends JsonResource
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
            'ascii' => $this->ascii,
            'unicode' => $this->unicode,
            'hex' => $this->hex
        ];
    }
}
