<?php

namespace App\View\Components\LayoutElements;

use Illuminate\View\Component;

class EventElementsList extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $currencies;
    public $event;
    public $eventElements;
    public $eventContractors;
    public $payments;

    public function __construct($currencies, $event, $eventElements, $eventContractors, $payments)
    {
        //
        $this->currencies = $currencies;
        $this->event = $event;
        $this->eventElements = $eventElements;
        $this->eventContractors = $eventContractors;
        $this->payments = $payments;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layout-elements.event-elements-list');
    }
}
