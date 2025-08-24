<?php

namespace App\View\Components\Modals;

use Illuminate\View\Component;

class CreateNoteModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $todoId;
    public $eventId;

    public function __construct($todoId, $eventId = '')
    {
        //
        $this->todoId = $todoId;
        $this->eventId = $eventId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */

    public function render()
    {
        return view('components.modals.create-note-modal');
    }
}
