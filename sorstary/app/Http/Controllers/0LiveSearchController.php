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
        if (!empty($request['eventOfficeId'])) {
            $q->where('eventOfficeId', 'LIKE', '%' . $request['eventOfficeId'] . '%');
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

        ////////////////////////// próba dodania wyszukiwania po kontrahencie //////////////////////////////////////

        $contractor = $request['contractor'];

        if(!empty($contractor)){
            $q->whereHas('eventcontractor1', function($q) use($contractor)
            {
                $q->where('name', $contractor);
            });
        }

        ////////////////////////// koniec wyszukiwania po kontraghencie ////////////////////////////////////////////



        $events = $q->with('eventcontractors')->get();

        return response()->json([
            'events' => $events
        ]);
    }
    public function contractors(Request $request)
    {
        $q = Contractor::query();
        if (!empty($request['name'])) {
            $q->where('name', 'LIKE', '%' . $request['name'] . '%');
        }
        if (!empty($request['firstname'])) {
            $q->where('firstname', 'LIKE', '%' . $request['firstname'] . '%');
        }
        if (!empty($request['surname'])) {
            $q->where('surname', 'LIKE', '%' . $request['surname'] . '%');
        }
        if (!empty($request['street'])) {
            $q->where('street', 'LIKE', '%' . $request['street'] . '%');
        }
        if (!empty($request['city'])) {
            $q->where('city', 'LIKE', '%'. $request['city'].'%');
        }
        if (!empty($request['phone'])) {
            $q->where('phone', 'LIKE', '%'.$request['phone'].'%');
        }
        if (!empty($request['email'])) {
            $q->where('email',  'LIKE', '%'.$request['email'].'%');
        }

        $type = $request['type'];

        if(!empty($type)){
            $q->whereHas('type', function($q) use($type)
            {
                $q->where('contractor_type_id', $type);
            });
        }

        $contractors = $q->with('type')->get();

        // dd($contractors);

        return response()->json([
            'contractors' => $contractors
        ]);
    }
}
