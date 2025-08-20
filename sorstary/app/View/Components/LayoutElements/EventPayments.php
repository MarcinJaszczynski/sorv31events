<?php

namespace App\View\Components\LayoutElements;

use Illuminate\View\Component;

class EventPayments extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $contractorstypes;
    public $currencies;
    public $event;
    public $payments;
    public $paymenttypes;

    public function __construct($contractorstypes, $currencies, $event, $payments, $paymenttypes)
    {
        //
        $this->contractorstypes = $contractorstypes;
        $this->currencies = $currencies;
        $this->event = $event;
        $this->payments = $payments;
        $this->paymenttypes = $paymenttypes;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layout-elements.event-payments');
    }
}
