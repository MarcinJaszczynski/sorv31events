<?php

namespace App\View\Components\LayoutElements;

use Illuminate\View\Component;

class SummernoteEditor extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $summernoteText;
    public $name;


    // public function __construct($summernoteName, $summernoteText)
    public function __construct($summernoteText, $name)
    {
        //
        $this->name = $name;
        $this->summernoteText = $summernoteText;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layout-elements.summernote-editor');
    }
}
