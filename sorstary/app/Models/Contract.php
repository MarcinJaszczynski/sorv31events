<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'contractor_first_name',
        'contractor_last_name',
        'contractor_email',
        'contractor_contact_phone',
        'tour_participant_first_name',
        'tour_participant_last_name',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
