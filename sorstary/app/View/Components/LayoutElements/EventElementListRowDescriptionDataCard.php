<?php

namespace App\View\Components\LayoutElements;

use Illuminate\View\Component;

class EventElementListRowDescriptionDataCard extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layout-elements.event-element-list-row-description-data-card');
    }
}
