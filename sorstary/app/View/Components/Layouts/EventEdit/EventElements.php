<?php

namespace App\View\Components\Layouts\EventEdit;

use Illuminate\View\Component;

class EventElements extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $eventElements;

    public function __construct($eventElements)
    {
        //
        $this->eventElements = $eventElements;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layouts.event-edit.event-elements');
    }
}
