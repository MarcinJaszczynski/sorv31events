<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventContractor;
use Barryvdh\Debugbar\DataCollector\EventCollector;
use Illuminate\Http\Request;

class EventContractorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = EventContractor::all();
        return response()->json(['eventcontractors' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //nie przewiduję możliwości tworzenia w osobnym ekranie

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
        $this->validate($request, [
            'contractor_id' => 'required',
        ]);
        $input = $request->except(['_token']);
        EventContractor::create($input);
        $event = Event::findOrFail($request->event_id);
        return view('events.edit', ['event' => $event]);

    }

    public function createElementContractor(Request $request)
    {
        $this->validate($request, [
            'contractor_id' => 'required',
        ]);
        $input = $request->except(['_token']);
        EventContractor::create($input);
        $event = Event::findOrFail($request->event_id);
        return view('events.edit', ['event' => $event]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EventContractor  $eventContractor
     * @return \Illuminate\Http\Response
     */
    public function show(EventContractor $eventContractor)
    {
        //
        $eventcontractor = EventContractor::find($eventContractor);
        return response()->json(['eventcontractor' => $eventContractor]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EventContractor  $eventContractor
     * @return \Illuminate\Http\Response
     */
    public function edit(EventContractor $eventContractor)
    {
        //
        return response()->json(['eventContractor' => $eventContractor]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EventContractor  $eventContractor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventContractor $eventContractor)
    {
        //
        $data = $request->validate();
        $eventContractor->update($data);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EventContractor  $eventContractor
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventContractor $eventcontractor)
    {

        $event = Event::findOrFail($eventcontractor->event_id);


        $eventcontractor->delete();
        return view('events.edit', ['event' => $event]);
    }

    public function geteventcontractor(Request $request){
        $q = EventContractor::query();
        if (!empty($request['eventcontractorid'])){
            $q->where('id', $request['eventcontractorid']);
        }
        $eventcontractors = $q->with('event')->with('contractor')->get();

        return response()->json([
            'eventcontractors' => $eventcontractors
        ]);
    }
    public function updateeventcontractor(Request $request){
        $eventcontractor = EventContractor::find($request['id']);
        $eventcontractor['desc'] = $request['desc'];
        $eventcontractor->save();
        return back();
    }
}