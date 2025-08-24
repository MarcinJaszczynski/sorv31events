<?php

namespace App\View\Components\Modals;

use Illuminate\View\Component;

class AddEventPaymentModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $currencies;
    public $event;

    public function __construct($currencies, $event)
    {
        //
        $this->currencies = $currencies;
        $this->event = $event;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modals.add-event-payment-modal');
    }
}
