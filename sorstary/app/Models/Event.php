<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EventElement;
use App\Models\Eventfile;
use App\Models\Hotel;
use App\Models\Contract;
use App\Models\Contractor;
use App\Models\EventPayment;
use App\Models\EventContractor;

use Illuminate\Support\Facades\DB;



class Event extends Model
{
    use HasFactory;

    protected $fillable = [

        'eventName',
        'eventOfficeId',
        'eventNote',
        'eventStartDateTime',
        'eventEndDateTime',
        'eventStartDescription',
        'eventEndDescription',
        'eventDietAlert',
        'eventTotalQty',
        'eventGuardiansQty',
        'eventFreeQty',
        'eventStatus',
        'eventPurchaserName',
        'eventPurchaserStreet',
        'eventPurchaserCity',
        'eventPurchaserNip',
        'eventPurchaserContactPerson',
        'eventPurchaserTel',
        'eventPurchaserEmail',
        'eventPilot',
        'eventDriver',
        'eventAdvancePayment',
        'eventPilotNotes',
        'busBoardTime',
        'duration',
        'todo_id',
        'purchaser_id',
        'author_id',
        'orderNote',
        'statusChangeDatetime'

    ];

    public function accomodation()
    {
        return $this->belongTo(Accommodation::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function files()
    {
        return $this->hasMany(Eventfile::class, 'eventId', 'id');
    }

    public function eventElements()
    {
        return $this->hasMany(EventElement::class, 'eventIdinEventElements', 'id');
    }

    public function hotels()
    {
        return $this->belongsToMany(Hotel::class, 'event_hotel')->withPivot('eventHotelNote', 'eventHotelStartDate', 'eventHotelEndDate', 'eventHotelRooms');
    }

    public function eventPayment()
    {
        return $this->hasMany(EventPayment::class, 'event_id', 'id');
    }

    public function getEventElements($id)
    {

        $eventElements = DB::table('event_elements')->where('eventIdinEventElements', $id)->orderBy('eventElementStart', 'asc')->get();

        return $eventElements;
    }

    public function totalSum($id)
    {
        $total = DB::table('event_payments')->where('event_id', $id)->sum(DB::raw('qty * price'));

        return $total;
    }

    public function hotelTotal($id)
    {
        $total = DB::table('event_payments')->with('event_elements')->where('contractortype_id', 1)->sum(DB::raw('qty*price'));
        return $total;
    }
    public function plannedHotelTotal($id)
    {
        $total = DB::table('event_payments')->with('event_elements')->where('contractortype_id', 1)->sum(DB::raw('qty*price'));
        return $total;
    }
    public function plannedTotalSum($id)
    {
        $total = DB::table('event_payments')->where('event_id', $id)->sum(DB::raw('plannedQty * plannedPrice'));

        return $total;
    }

    public function pilotSum($id)
    {

        $total = DB::table('event_payments')->where('event_id', $id)->where('payer', 'pilot')->sum(DB::raw('qty * price'));
        return $total;
    }

    public function plannedPilotSum($id)
    {

        $total = DB::table('event_payments')->where('event_id', $id)->where('payer', 'pilot')->sum(DB::raw('plannedQty * plannedPrice'));
        return $total;
    }

    public function paidSum($id)
    {

        $total = DB::table('event_payments')->where('event_id', $id)->where('paymentStatus', '1')->sum(DB::raw('qty * price'));

        return $total;
    }

    // public function todo()
    // {
    //     return $this->hasMany(Todo::class);
    // }

    public function contract()
    {
        return $this->hasMany(Contract::class);
    }

    public function note()
    {
        return $this->hasMany(Note::class);
    }

    public function todo()
    {
        return $this->hasMany(Todo::class);
    }

    public function purchaser()
    {
        return $this->belongsTo(Contractor::class);
    }

    public function eventcontractor()
    {
        return $this->hasMany(EventContractor::class);
    }
    public function eventcontractor1()
    {
        return $this->belongsToMany(EventContractor::class, 'event_contractors', 'event_id', 'contractor_id');
    }

    // public function contractors(){
    //     return $this->belongsToMany(Contractor::class);
    // }
    public function eventcontractors()
    {
        return $this->belongsToMany(Contractor::class, 'event_contractors', 'event_id', 'contractor_id')->withPivot('contractortype_id');
    }
}
