<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;



class EventElement extends Model
{
    use HasFactory;

    protected $fillable = [
        'element_name',
        'eventIdinEventElements',
        'eventElementDescription',
        'eventElementPilotPrint',
        'eventElementHotelPrint',
        'eventElementStart',
        'eventElementEnd',
        'eventElementCost',
        'eventElementCostStatus',
        'eventElementCostPayer',
        'eventElementNote',
        'eventElementCostQty',
        'eventElementCostNote',
        'eventElementContact',
        'eventElementReservation',
        'eventElementInvoiceNo',
        'booking',
        'last_change_user_id',
        'active'
    ];


    public function events()
    {
        return $this->belongsTo(Event::class, 'id', 'eventId');

    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function eventPayment()
    {
        return $this->hasMany(EventPayment::class);
    }

    public function event()
    {
        return $this->hasOne(Event::class, 'id', 'eventIdinEventElements');
    }

    public function bookingType()
    {
        return $this->belongsTo(EventContractor::class);
    }

    public function elementContractor()
    {
        return $this->belongsToMany('App\Models\Contractor', 'event_contractors', 'eventelement_id', 'contractor_id');
    }

    public function eventElementContractor(){
        return $this->belongsTo(EventContractor::class);
    }


}