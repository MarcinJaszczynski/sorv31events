<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ContractorSearch extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $contractor;

    public function __construct($contractor)
    {
        //
        $this->contractor = $contractor;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.contractor-search');
    }
}
