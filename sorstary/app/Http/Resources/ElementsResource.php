<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ElementsResource extends JsonResource
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
            'element_name' => $this->element_name,
            'eventIdinEventElements' => $this->eventIdinEventElements,
            'eventElementDescription' => $this->eventElementDescription,
            'eventElementPilotPrint' => $this->eventElementPilotPrint,
            'eventElementHotelPrint' => $this->eventElementHotelPrint,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'eventElementStart' => $this->eventElementStart,
            'eventElementEnd' => $this->eventElementEnd,
            'eventElementCost' => $this->eventElementCost,
            'eventElementCostStatus' => $this->eventElementCostStatus,
            'eventElementCostPayer' => $this->eventElementCostPayer,
            'eventElementNote' => $this->eventElementNote,
            'eventElementCostQty' => $this->eventElementCostQty,
            'eventElementCostNote' => $this->eventElementCostNote,
            'eventElementContact' => $this->eventElementContact,
            'eventElementReservation' => $this->eventElementReservation,
            'eventElementInvoiceNo' => $this->eventElementInvoiceNo,
            'last_change_user_id' => $this->last_change_user_id,
            'booking' => $this->booking,
            'contractor_id' => $this->contractor_id,
            'active' => $this->active
        ];
    }
}