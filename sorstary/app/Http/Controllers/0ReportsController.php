<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;

class ReportsController extends Controller
{
    //
    public function entrantsReport(Request $request){
        $start = '';
        $end = '';
        $q = Event::query();

        if (!empty($request['start'])) {
            $start = $request['start'];
            $q->where('eventStartDateTime', '>=',  $request['start']);
        }
        if (!empty($request['end'])) {
            $end = $request['end'];
            $q->where('eventStartDateTime', '<=',  $request['end']);
        }



        $data = $q->orderBy('eventStartDateTime')->get();
        

        
        

        return view('reports/entrants', compact('data', 'request'));
    }
}
