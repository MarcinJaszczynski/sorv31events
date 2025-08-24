<?php

namespace App\Models;

use Faker\Provider\ar_EG\Payment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
    use HasFactory;
    protected $guarded = [];


    protected $fillable = [

        'name',
        'firstname',
        'surname',
        'street',
        'city',
        'region',
        'country',
        'nip',
        'phone',
        'email',
        'www',
        'description',
        'event_id'
    ];

    public function accomodation()
    {
        return $this->belongsTo(Accommodation::class);
    }

    public function event()
    {
        return $this->hasOne(Event::class, 'events');
    }

    public function todo()
    {
        return $this->hasMany(Todo::class);
    }

    public function type()
    {
        return $this->belongsToMany(ContractorType::class, 'contractor_contractortype');
    }

    public function payment()
    {
        return $this->hasMany(Payment::class);
    }
}
