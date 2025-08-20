<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Contractor;


class LiveSearchController extends Controller
{
    //
    public function event(Request $request)
    {
        $q = Event::query();
        if (!empty($request['eventName'])) {
            $q->where('eventName', 'LIKE', '%' . $request['eventName'] . '%');
        }
        if (!empty($request['start'])) {
            $q->where('eventStartDateTime', '>=',  $request['start']);
        }
        if (!empty($request['end'])) {
            $q->where('eventEndDateTime', '<=',  $request['end']);
        }
        if (!empty($request['status'])) {
            $q->where('eventStatus',  $request['status']);
        }

        $events = $q->with('eventcontractors')->get();

        return response()->json([
            'events' => $events
        ]);
    }
}
