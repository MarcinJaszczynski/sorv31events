<?php

namespace App\View\Components\LayoutElements;

use Illuminate\View\Component;

class EventElementsListRow extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $eventElement;

    public function __construct($eventElement)
    {
        //
        $this->eventElement = $eventElement;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layout-elements.event-elements-list-row');
    }
}
