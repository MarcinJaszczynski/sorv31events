<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'author_id',
        'contractor_id',
        'event_id',
        'todo_id',
        'event_element_id',
        'note_id',
    ];

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function contractor()
    {
        return $this->hasOne(Contractor::class);
    }


    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function todo()
    {
        return $this->belongsTo(Todo::class);
    }

    public function eventElement()
    {
        return $this->hasOne(EventElement::class);
    }

    public function parentNote()
    {
        return $this->hasOne(Note::class);
    }

    public function childNote()
    {
        return $this->belongsTo(Note::class);
    }
}
