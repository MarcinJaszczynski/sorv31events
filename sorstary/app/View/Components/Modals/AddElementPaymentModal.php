<?php

namespace App\View\Components\Modals;

use Illuminate\View\Component;

class AddElementPaymentModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $currencies;
    public $event;
    public $element;


    public function __construct($currencies = '', $event = '', $element = '')
    {
        //
        $this->currencies = $currencies;
        $this->event = $event;
        $this->element = $element;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modals.add-element-payment-modal');
    }
}