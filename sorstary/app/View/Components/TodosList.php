<?php

namespace App\View\Components;

use Illuminate\View\Component;


class TodosList extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $todo;
    public $executors;

    public function __construct($todo, $executors)
    {
        //
        $this->todo = $todo;
        $this->executors = $executors;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.todos-list');
    }
}
