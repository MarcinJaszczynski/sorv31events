<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    use HasFactory;

    public function author()
    {
        return $this->hasOne(User::class);
    }

    public function event()
    {
        return $this->hasOne(Event::class);
    }

    public function contractor()
    {
        return $this->hasOne(Contractor::class);
    }
}
