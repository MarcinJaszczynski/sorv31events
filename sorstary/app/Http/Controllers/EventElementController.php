<?php

namespace App\Http\Controllers;

use App\Models\EventElement;
use App\Models\Event;
use App\Models\Hotel;
use App\Http\Resources\ElementsResource;


use Illuminate\Http\Request;

class EventElementController extends Controller
{
    //
    public function index()
    {
        //
        $data = EventElement::all();
        return view('eventelements.index', compact('data'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'element_name' => 'required',          

        ]);
        $input = $request->except(['_token']);
        $input['active'] = $request->active == 'on' ? 1 : 0;
        $event = Event::findOrFail($request->eventIdinEventElements);
        $element=EventElement::create($input);
        $allHotels = Hotel::all();
        return redirect()->route('events.edit', compact('event', 'allHotels'));
    }

    public function edit(EventElement $eventelement)
    {
        return view('eventelements.edit', compact('eventelement'));
    }

    public function destroy(EventElement $eventelement)
    {
        $event = Event::findOrFail($eventelement->eventIdinEventElements);
        $eventelement->delete();

        $allHotels = Hotel::all();
        return redirect()->route('events.edit', compact('event', 'allHotels'));
    }

    public function getAllElements()
    {
        $elements = EventElement::all();
        return response()->json(['success' => true, 'elements' => $elements]);
    }
    public function getElement($id)
    {
        $element = EventElement::query()->find($id);
        if (!$element) {
            return response()->json(['success' => false, 'message' => 'Element does not exist']);
        }
        return response()->json(['success' => true, 'element' => new ElementsResource($element)]);
    }

    public function update(Request $request, $id)
    {
        $request->active == 'on' ? 1 : 0;

        $this->validate($request, [
            'element_name' => 'required',
            

        ]);
        $input = $request->except(['_token', '_method', 'id', 'files']);
        $eventElement = EventElement::findOrFail($id);
        $input['active'] = $request->active == 'on' ? 1 : 0;
        $eventElement->update($input);
        $event = Event::find($request['eventIdinEventElements']);
        $allHotels = Hotel::all();
        return redirect()->route('events.edit', compact('event', 'allHotels'));
    }


}