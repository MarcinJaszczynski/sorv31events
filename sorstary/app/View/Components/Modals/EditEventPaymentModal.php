<?php

namespace App\View\Components\Modals;

use Illuminate\View\Component;

class EditEventPaymentModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $event;
    public $currencies;

    public function __construct($event, $currencies)
    {
        //
        $this->event = $event;
        $this->currencies = $currencies;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modals.edit-event-payment-modal');
    }
}
