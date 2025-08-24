<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'desc',
    ];

    // public function advance()
    // {
    //     return $this->belongsTo(Advance::class);
    // }

    public function eventPayment()
    {
        return $this->hasMany(EventPayment::class);
    }
}
