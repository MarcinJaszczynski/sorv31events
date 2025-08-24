<?php

namespace App\View\Components\LayoutElements;

use Illuminate\View\Component;

class TodosList extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $todos;

    public function __construct($todos)
    {
        //
        $this->todos = $todos;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layout-elements.todos-list');
    }
}
