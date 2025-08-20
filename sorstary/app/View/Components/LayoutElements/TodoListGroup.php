<?php

namespace App\View\Components\LayoutElements;

use Illuminate\View\Component;

class TodoListGroup extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $executors;
    public $myTodos;
    public $pendingTodos;
    public $finishedTodos;
    public $acceptedTodos;

    public function __construct($executors='', $myTodos='', $pendingTodos='', $finishedTodos='', $acceptedTodos='')
    {
        //
        $this->executors = $executors;
        $this->myTodos = $myTodos;
        $this->pendingTodos = $pendingTodos;
        $this->finishedTodos = $finishedTodos;
        $this->acceptedTodos = $acceptedTodos;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layout-elements.todo-list-group');
    }
}
