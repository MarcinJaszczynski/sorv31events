<?php

namespace App\View\Components\Modals;

use Illuminate\View\Component;

class addEventHotelModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $eventid;

    public function __construct($eventid)
    {
        $this->eventid = $eventid;        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modals.add-event-hotel-modal');
    }
}
