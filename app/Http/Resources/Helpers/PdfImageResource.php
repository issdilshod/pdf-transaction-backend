<?php

namespace App\Http\Resources\Helpers;

use Illuminate\Http\Resources\Json\JsonResource;

class PdfImageResource extends JsonResource
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
            'id'=> $this->id,
            'period' => $this->period
        ];
    }
}
