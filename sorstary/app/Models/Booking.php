<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'booking_start',
        'booking_end',
        'confirmation_deadline',
        'confirmation_date',
        'cancelation_deadline',
        'cancelation_date',
        'description',
        'author_id',
        'contractor_id',
        'todo_id',
        'event_id',
        'event_element_id',
        'note_id'
    ];

    public function author()
    {
        return $this->hasOne(User::class);
    }
    public function contractor()
    {
        return $this->hasOne(User::class);
    }
    public function todo()
    {
        return $this->hasOne(Todo::class);
    }
    public function event()
    {
        return $this->hasOne(Event::class);
    }
    public function eventelement()
    {
        return $this->hasOne(EventElement::class);
    }
    public function note()
    {
        return $this->hasOne(Note::class);
    }
}
