<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'event_id' => $this->id,
            'event_Name' => $this->eventName,
            'event_OfficeId' => $this->eventOfficeId,
            'event_purchaser' => new ContractorResource($this->purchaser_id)

        ];
    }
}
