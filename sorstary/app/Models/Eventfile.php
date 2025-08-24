<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;


class Eventfile extends Model
{
    use HasFactory;

    protected $fillable=[
        'fileName', 
        'FileNote', 
        'filePilotSet', 
        'fileHotelSet', 
        'eventId',

];

    public function events(){
        return $this->belongsTo(Event::class, 'id', 'eventId');
    }
}
