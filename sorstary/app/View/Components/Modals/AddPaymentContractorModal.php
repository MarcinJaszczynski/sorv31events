<?php

namespace App\View\Components\Modals;

use Illuminate\View\Component;

class AddPaymentContractorModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $contractorstypes;


    public function __construct($contractorstypes)
    {
        //
        $this->contractorstypes = $contractorstypes;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modals.add-payment-contractor-modal');
    }
}
