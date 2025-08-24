<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'urgent',
        'principal_id',
        'event_id',
        'status_id',
        'executor_id',
        'contractor_id',
        'note_id',
        'deadline',
        'last_update',
        'private'

    ];
    public function principal()
    {
        return $this->belongsTo(User::class);
    }
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function status()
    {
        return $this->belongsTo(TodoStatus::class);
    }
    public function executor()
    {
        return $this->belongsTo(User::class);
    }

    public function note()
    {
        return $this->hasMany(Note::class);
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }
    public function isSelectedExecutor(int $executor_id)
    {
        return !is_null($this->executor_id) && $this->executor_id->id == $executor_id;
    }
}