<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\Contractor;
use App\Models\ContractorType;
use App\Models\EventContractor;


class EventinitController extends Controller
{
    //
    public function index()
    {
        return view('eventinit.index');
    }

    public function search(Request $request)
    {
        dd($request);

        $output = '';

        if ($request->ajax()) {
            $contractors = Contractor::where('name', 'LIKE', '%' . $request->search . '%')->get();
            if ($contractors) {
                foreach ($contractors as $contractor) {
                }
            }

            if ($contractors) {

                foreach ($contractors as $contractor) {

                    $output .=
                        '
                        <h5 class="card-title"><b>' . $contractor->name->title . '</b></h5>
                   
                  ';
                }

                return response()->json($output);
            }
            return response($output);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'eventName' => 'required',
        ]);
        if ($request->purchaser_id != '0') {
            $input = $request->except(['_token']);

            $event = Event::create($input);
            $event['statusChangeDatetime'] = now();


            $purchaser = new EventContractor();

            // $purchaser->event_id = $event->id;
            // $purchaser->contractortype_id = '4';
            // $purchaser->contractor_id = $request->purchaser_id;
            // $purchaser->save();

            $eventContractor = new EventContractor;
            $eventContractor['event_id'] = $event->id;
            $eventContractor['contractor_id'] = $request->purchaser_id;
            $eventContractor['contractortype_id'] = '4';
            $eventContractor->save();

            $data = Event::with('todo')
                ->where('eventStatus', 'Zapytanie')
                ->orderBy('created_at', 'desc')
                ->paginate(25);


            return view('events.index', compact('data'));
        } else {

            $contractor = $request->validate([
                'name' => 'required|max:200',
                'firstname' => 'nullable|max:100',
                'surname' => 'nullable|max:100',
                'street' => 'nullable|max:200',
                'city' => 'nullable|max:200',
                'region' => 'nullable|max:200',
                'country' => 'nullable|max:200',
                'nip' => 'nullable|max:200',
                'phone' => 'nullable|max:20',
                'email' => 'nullable|email|max:200',
                'www' => 'nullable|max:200',
                'description' => 'nullable|max:3000',
            ]);

            $newContractor = Contractor::create($contractor);
            $newContractor->save();
            $contractorType = ContractorType::find(4);
            $newContractor->type()->attach($contractorType);

            $event = $request->validate(
                [
                    'eventName' => 'required|max:200',
                    'eventOfficeId' => 'nullable|max:200',
                    'eventTotalQty' => 'nullable|max:200',
                    'eventStatus' => 'nullable|max:200',
                    'duration' => 'nullable|max:200',
                    'eventStartDateTime' => 'nullable|max:200',
                    'eventEndDateTime' => 'nullable|max:200',
                    'eventNote' => 'nullable',
                    'orderNote' => 'nullable',
                    'author_id' => 'nullable|max:200'
                ]
            );

            $newEvent = Event::create($event);
            // $newEvent['purchaser_id'] = $newContractor->id;
            $newEvent['busBoardTime'] = $newEvent->eventStartDateTime;
            $newEvent['statusChangeDatetime'] = now();


            $newEvent->save();

            $eventContractor = new EventContractor;
            $eventContractor['event_id'] = $newEvent->id;
            $eventContractor['contractor_id'] = $newContractor->id;
            $eventContractor['contractortype_id'] = '4';
            $eventContractor->save();

            $data = Event::with('todo')
                ->where('eventStatus', 'Zapytanie')
                ->orderBy('created_at', 'desc')
                ->paginate(25);


            return view('events.index', compact('data'));
        }
    }
}
