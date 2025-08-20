<?php

namespace App\View\Components\LayoutElements;

use Illuminate\View\Component;

class TodoCollapseList extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $myTodos;
    public $pendingTodos;
    public $finishedTodos;
    public $myOrders;
    public $pendingOrders;
    public $finishedOrders;
    public $newAllTodos;
    public $pendingAllTodos;
    public $finishedAllTodos;
     public $acceptedTodos;

    public function __construct(
        $myTodos,
        $pendingTodos,
        $finishedTodos,
        $myOrders,
        $pendingOrders,
        $finishedOrders,
        $newAllTodos,
        $pendingAllTodos,
        $finishedAllTodos,
        $acceptedTodos
    ) {
        //
        $this->myTodos = $myTodos;
        $this->pendingTodos = $pendingTodos;
        $this->finishedTodos = $finishedTodos;
        $this->myOrders = $myOrders;
        $this->pendingOrders = $pendingOrders;
        $this->finishedOrders = $finishedOrders;
        $this->newAllTodos = $newAllTodos;
        $this->pendingAllTodos = $pendingAllTodos;
        $this->finishedAllTodos = $finishedAllTodos;
        $this->acceptedTodos = $acceptedTodos;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layout-elements.todo-collapse-list');
    }
}
