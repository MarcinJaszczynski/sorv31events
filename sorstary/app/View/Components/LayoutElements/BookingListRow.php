<?php

namespace App\View\Components\LayoutElements;

use Illuminate\View\Component;

class BookingListRow extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $element;

    public function __construct($element)
    {
        //
        $this->element = $element;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layout-elements.booking-list-row');
    }
}