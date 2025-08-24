<?php

namespace App\View\Components\LayoutElements;

use Illuminate\View\Component;

class TodosListRow extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $todo;

    public function __construct($todo)
    {
        //
        $this->todo = $todo;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layout-elements.todos-list-row');
    }
}
