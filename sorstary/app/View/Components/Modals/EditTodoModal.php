<?php

namespace App\View\Components\Modals;

use Illuminate\View\Component;

class EditTodoModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $todo;
    public $executors;
    public $todoStatuses;

    public function __construct($todo, $executors, $todoStatuses)
    {
        //
        $this->todo = $todo;
        $this->executors = $executors;
        $this->todoStatuses = $todoStatuses;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modals.edit-todo-modal');
    }
}
