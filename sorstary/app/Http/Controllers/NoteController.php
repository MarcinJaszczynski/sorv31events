<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use App\Models\Note;
use App\Models\User;
use App\Models\Event;
use App\Models\Todo;
use App\Models\EventElement;
use Illuminate\Http\Request;
use Carbon\Carbon;


use function Ramsey\Uuid\v1;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('notes.create');
    }

    public function add_note_with_request(Request $request)
    {
        $data = $request->all();
        return view('notes.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //
        // TODO - usunąć name lub description, contarctor_id, event_element_id, note_id zmienić nazwę na comment
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'string|nullable',
            'author_id' => 'numeric|nullable',
            'contractor_id' => 'numeric|nullable',
            'event_id' => 'numeric|nullable',
            'todo_id' => 'numeric|nullable',
            'event_element_id' => 'numeric|nullable',
            'note_id' => 'numeric|nullable',
        ]);
        $note = new Note;
        $note['name'] = $validated['name'];
        if (isset($validated['description'])) {
            $note['description'] = $validated['description'];
        }
        if (isset($validated['author_id'])) {
            $author = User::find($validated['author_id']);
            $note['author_id'] = $author->id;
        }
        if (isset($validated['contractor_id'])) {
            $contractor = Contractor::find($validated['contractor_id']);
            $note['contractor_id'] = $contractor->id;
        }
        if (isset($validated['event_id'])) {
            $event = Event::find($validated['event_id']);
            $note['event_id'] = $event->id;
        }
        if (isset($validated['todo_id'])) {
            $todo = Todo::find($validated['todo_id']);
            $note['todo_id'] = $todo->id;
        }
        if (isset($validated['event_element_id'])) {
            $eventelement = EventElement::find($validated['event_element_id']);
            $note['event_element_id'] = $eventelement->id;
        }
        if (isset($validated['note_id'])) {
            $parentnote = EventElement::find($validated['note_id']);
            $note['note_id'] = $parentnote->id;
        }
        $note->save();
        $todo = Todo::findOrFail($request->todo_id);
        $todo->last_update = Carbon::now()->toDateTimeString();
        $todo->save();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        //
    }
}
