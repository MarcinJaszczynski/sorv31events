<?php

namespace App\View\Components\Modals;

use Illuminate\View\Component;

class AddPaymentModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $event;
    public $element;

    public function __construct($event = '', $element = '')
    {
        //
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
        return view('components.modals.add-payment-modal');
    }
}
