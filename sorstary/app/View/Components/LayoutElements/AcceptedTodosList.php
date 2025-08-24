<?php

namespace App\View\Components\LayoutElements;

use Illuminate\View\Component;

class AcceptedTodosList extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $acceptedTodos;
    public $executors;

    public function __construct($acceptedTodos, $executors)
    {
        //
        $this->acceptedTodos = $acceptedTodos;
        $this->executors = $executors;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layout-elements.accepted-todos-list');
    }
}
