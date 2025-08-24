<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;
use App\Models\Advance;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Support\Facades\DB;



class EventPayment extends Model
{
    use HasFactory;

    public $timestamps = false;


    protected $fillable = [
        'paymentName',
        'paymentDescription',
        'event_id',
        'payer',
        'paymentStatus',
        'invoice',
        'paymentDate',
        'qty',
        'price',
        'paymentNote',
        'advance',
        'plannedQty',
        'plannedPrice',
        'currency_id',
        'exchange_rate',
        'planned_currency_id',
        'planned_exchange_rate',
        'element_id',
        'contractor_id',
        'paymenttype_id',
        'accepted'
    ];

    public function events()
    {
        return $this->belongsTo(Event::class, 'id', 'event_id');
    }

    public function paymentEvents()
    {
        return $this->hasOne(Event::class, 'id', 'event_id');
    }

    public function payment_type()
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function eventElement()
    {
        return $this->belongsTo(EventElement::class);
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function paymentCurrency(){
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function advance()
    {
        return $this->belongsTo(Advance::class);
    }
}