<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventContractor extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'eventelement_id',
        'contractor_id',
        'contractortype_id',
        'desc'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function eventelement()
    {
        return $this->hasOne(EventElement::class);
    }
    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }


}