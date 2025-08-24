<?php

namespace App\View\Components\Modals;

use Illuminate\View\Component;

class AddAdvanceModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $currencies;
    public $paymenttypes;

    public function __construct($currencies, $paymenttypes)
    {
        $this->currencies = $currencies;
        $this->paymenttypes = $paymenttypes;
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modals.add-advance-modal');
    }
}
