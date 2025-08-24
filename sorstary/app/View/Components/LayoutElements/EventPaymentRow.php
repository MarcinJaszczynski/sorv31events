<?php

namespace App\View\Components\LayoutElements;

use Illuminate\View\Component;

class EventPaymentRow extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $payment;
    public $currencies;

    public function __construct($payment, $currencies)
    {
        //
        $this->payment = $payment;
        $this->currencies = $currencies;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layout-elements.event-payment-row');
    }
}
