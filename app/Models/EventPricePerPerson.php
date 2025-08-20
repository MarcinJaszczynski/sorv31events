<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventPricePerPerson extends Model
{
    protected $table = 'event_price_per_person';

    protected $fillable = [
        'event_id',
        'event_template_qty_id',
        'currency_id',
        'start_place_id',
        'price_per_person',
        'transport_cost',
        'price_base',
        'markup_amount',
        'tax_amount',
        'price_with_tax',
        'tax_breakdown',
    ];

    protected $casts = [
        'price_per_person' => 'decimal:2',
        'transport_cost' => 'decimal:2',
        'price_base' => 'decimal:2',
        'markup_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'price_with_tax' => 'decimal:2',
        'tax_breakdown' => 'array',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
