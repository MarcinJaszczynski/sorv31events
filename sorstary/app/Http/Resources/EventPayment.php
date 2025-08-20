<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EventPayment extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'paymentName' => $this->paymentName,
            'paymentDescription' => $this->paymentDescription,
            'event_id' => $this->event_id,
            'payer' => $this->payer,
            'paymentStatus' => $this->paymentStatus,
            'invoice' => $this->invoice,
            'paymentDate' => $this->paymentDate,
            'qty' => $this->qty,
            'price' => $this->price,
            'paymentNote' => $this->paymentNote,
            'advance' => $this->advance,
            'plannedQty' => $this->plannedQty,
            'plannedPrice' => $this->plannedPrice,
            'currency_id' => $this->currency_id,
            'exchange_rate' => $this->exchange_rate,
            'planned_currency_id' => $this->planned_currency_id,
            'planned_exchange_rate' => $this->planned_exchange_rate,
        ];
    }
}
