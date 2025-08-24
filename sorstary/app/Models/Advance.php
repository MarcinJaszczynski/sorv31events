<?php

namespace App\Models;

use Faker\Provider\ar_EG\Payment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advance extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'desc',
        'payment_id',
        'advance_date',
        'total',
        'currency_id',
        'paymenttype_id'
    ];

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class, 'paymenttype_id');
    }

    public function payment()
    {
        return $this->hasOne(EventPayment::class, 'payment_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}