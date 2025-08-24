<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;


class Hotel extends Model
{
    use HasFactory;

    protected $fillable=[
        'hotelName',
        'hotelStreet',
        'hotelCity',
        'hotelRegion',
        'hotelContact',
        'hotelPhone',
        'hotelEmail',
        'hotelNote'
    ];

    public $timestamps = false;

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_hotel')->withPivot('eventHotelNote', 'eventHotelStartDate', 'eventHotelEndDate', 'eventHotelRooms');
    }


}
