<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Hotel;
use App\Models\Eventfile;
use App\Models\EventElement;
use App\Models\EventPayment;
use App\Models\Todo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


use App\Http\Resources\EventResource;



class EventController extends Controller
{
    /**
     * create a new instance of the class
     *
     * @return void
     */
    function __construct()
    {
        $this->middleware('permission:event-list|event-create|event-edit|event-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:event-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:event-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:event-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */





    public function index(Request $request)
    {
        $order = "'eventStartTime','asc'";

        if (request()->has('eventStatus')) {


            if (request('eventStatus' === 'Zapytanie')) {
                $order = "'createdAt', 'asc'";
            } elseif (request('eventStatus' === 'oferta')) {
                $order = "'statusChangeDatetime', 'asc'";
            } else {
                $order = "'eventStartTime','desc'";
            }


            $data = Event::orderBy($order)->where('eventStatus', request('eventStatus'))->paginate(50)->appends('eventStatus', request('eventStatus'));
            // } elseif (request()->has('createTime')) {
            //     $data = Event::orderBy('created_at', 'desc')->where('eventStatus', '!=', 'Archiwum')->paginate(50);
            // } elseif ($request->search === 'search') {
            //     $searchColumn = $request->searchColumn;
            //     $searchText = $request->searchText;


            //     $data = Event::query()->where($searchColumn, 'LIKE', '%' . $searchText . '%')->orderBy('eventStartDateTime', 'asc')->paginate(50);

            //     // dd($data);

            //     // $query = DB::table("employee") ->where('employee_name', 'LIKE', '%'.$search.'%')->get();

            // } else {
            // $data = Event::orderBy('eventStartDateTime', 'asc')->where('eventStatus','=','Planowana')->orWhere('eventStatus','=','Potwierdzona')->paginate(50);

            $data = Event::orderBy('eventStartDateTime', 'asc')
                ->where('eventStatus', '!=', 'Archiwum')
                ->where('eventStatus', '!=', 'Zapytanie')
                ->where('eventStatus', '!=', 'Anulowane')
                ->where('eventEndDateTime', '>', Carbon::now())
                ->paginate(50);
        }

        return view('events.index', compact('data'));
    }

    public function getEvent($id)
    {
        return new EventResource(Event::findOrFail($id));
    }



    public function inquiry()
    {
        $data = Event::with('todo')
            ->where('eventStatus', 'Zapytanie')
            ->orWhere('eventStatus', 'oferta')
            ->orderBy('created_at', 'desc')
            ->paginate(25);
        return view('events.inquiry', compact('data'));
    }

    public function getEvents(Request $request)
    {
        if ($request->eventStatus === 'Zapytanie') {
            $data = Event::with('todo')
                ->where('eventStatus', 'Zapytanie')
                ->orderBy('created_at', 'desc')
                ->paginate(25);
        } elseif ($request->eventStatus === 'oferta') {
            $data = Event::with('todo')
                ->where('eventStatus', 'oferta')
                ->orderBy('statusChangeDatetime', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(25);
        } elseif ($request->eventStatus === 'Potwierdzona') {
            $data = Event::with('todo')
                ->where('eventStatus', 'Potwierdzona')
                ->orWhere('eventStatus', 'OdprawaOK')
                ->orderBy('eventStartDateTime', 'asc')
                ->paginate(25);
        } elseif ($request->eventStatus === '1') {
            $data = Event::with('todo')
                ->where('eventStatus', 'Potwierdzona')
                ->orWhere('eventStatus', 'OdprawaOK')
                ->orderBy('statusChangeDatetime', 'desc')
                ->orderBy('updated_at', 'desc')
                ->orderBy('eventStartDateTime', 'asc')
                ->paginate(25);
        } elseif ($request->eventStatus === 'DoRozliczenia') {
            $data = Event::with('todo')
                ->where('eventStatus', 'DoRozliczenia')
                ->orderBy('eventEndDateTime', 'asc')
                ->paginate(25);
        } elseif ($request->eventStatus === 'Zakończona') {
            $data = Event::with('todo')
                ->where('eventStatus', 'Zakończona')
                ->orderBy('eventEndDateTime', 'asc')
                ->paginate(25);
        } elseif ($request->eventStatus === 'doanulacji') {
            $data = Event::with('todo')
                ->where('eventStatus', 'doanulacji')
                ->orderBy('statusChangeDatetime', 'asc')
                ->paginate(25);
        } elseif ($request->eventStatus === 'Anulowana') {
            $data = Event::with('todo')
                ->where('eventStatus', 'Anulowana')
                ->orderBy('eventStartDateTime', 'desc')
                ->paginate(25);
        } elseif ($request->eventStatus === 'Anulowana') {
            $data = Event::with('todo')
                ->where('eventStatus', 'Anulowana')
                ->orderBy('eventStartDateTime', 'desc')
                ->orderBy('eventStartDateTime', 'desc')
                ->paginate(25);
        } else {
            $data = Event::with('todo')
                ->orderBy('eventStartDateTime', 'desc')
                ->paginate(50);
        }





        return view('events.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.create');
    }

    public function eventinit()
    {
        return view('events.eventinit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'eventName' => 'required',
        ]);
        $input = $request->except(['_token']);

        Event::create($input);

        return redirect()->route('events.index')
            ->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::find($id);

        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::find($id);
        $allHotels = Hotel::all();


        return view('events.edit', compact('event', 'allHotels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $oldStatus = $event->eventStatus;


        $input = $request->all();
        if ($oldStatus != $request->eventStatus) {
            $event->statusChangeDatetime = now();
        }
        $event->fill($input)->save();
        return back();



        // $this->validate($request, [
        //     'eventName' => 'required',
        //     'eventOfficeId' => 'required',
        // ]);


        // $event = Event::find($id);

        // if ($event->eventStatus != $request->eventStatus) {
        //     $event->statusChangeDatetime = Carbon::now();
        //     // dd($event->statusChangeDatetime);
        // }
        // // dd($request);

        $event->update($request->all());



        return back()->with('success', 'impreza została zaktualizowana');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        $files = Eventfile::where('eventId', $event->id)->get();
        foreach ($files as $file) {
            if (File::exists("/storage/" . $file->fileName)) {
                File::delete("/storage/" . $file->fileName);
            }

            $event->steps->each->delete();

            $event->delete();
        }

        return redirect()->route('events.index')
            ->with('success', 'Event deleted successfully.');
    }

    public function fileDelete(Request $request)
    {
        $file = Eventfile::findOrFail($request->id);
        if (File::exists(public_path("storage/") . $file->fileName)) {
            File::delete(public_path("storage/") . $file->fileName);
        } else {
            dd('File does not exists.');
        }
        $file->delete();
        return back()->with('success', 'Plik skasowany');

        // {  
        //     if(\File::exists(public_path('upload/avtar.png'))){
        //       \File::delete(public_path('upload/avtar.png'));
        //     }else{
        //       dd('File does not exists.');
        //     }
        //   } 

    }

    // Zmienić na bez $d Update

    public function eventElementUpdate(Request $request)
    {

        $this->validate($request, [
            'elementId' => 'required',
        ]);
        $element = EventElement::find($request->elementId);
        // dd($request);    
        $element->update($request->all());

        return back();
    }

    public function eventElementStore(Request $request)
    {
        $this->validate($request, [
            'element_name' => 'required',
        ]);
        $input = $request->except(['_token']);
        EventElement::create($input);
        return back();
    }

    public function elementDelete($id)
    {
        $element = EventElement::findOrFail($id);
        $element->delete();

        return back()->with('success', 'Punkt programu skasowany');
    }

    // ////////////////////////////////////// START - Obsługa plików ///////////////////////////////

    public function fileStore(Request $request)
    {


        if ($request->hasFile('eventFile')) {

            $file = $request->File("eventFile");
            $fileName = time() . '_' . $request['fileName'] . '.' . $file->getClientOriginalExtension();
            $request['fileName'] = $fileName;

            $file->move(\public_path("/storage"), $fileName);
            Eventfile::create($request->all());

            return back()->with('success', 'Plik został dodany');
        }
    }

    public function eventFileUpdate(Request $request)
    {
        $input = $request->except(['_token']);

        $file = Eventfile::findOrFail($request->id);
        $file->update($input);

        $event = Event::find($request->eventId);
        $allHotels = Hotel::all();


        return back()->with('success', 'Plik został dodany');


        // return view('events.edit',compact('event','allHotels'));
    }


    public function eventHotelStore(Request $request)
    {


        $event = Event::findOrFail($request->event_id);
        $event->hotels()->attach($request->hotel_id, [
            'eventHotelNote' => $request->eventHotelNote,
            'eventHotelStartDate' => $request->eventHotelStartDate,
            'eventHotelEndDate' => $request->eventHotelEndDate,
            'eventHotelRooms' => $request->eventHotelRooms
        ],);
        return back()->with('success', 'Hotel został dodany');
    }

    public function eventHotelUpdate(Request $request)
    {


        $event = Event::findOrFail($request->event_id);
        $event->hotels()->updateExistingPivot($request->hotel_id, [
            'eventHotelNote' => $request->eventHotelNote,
            'eventHotelStartDate' => $request->eventHotelStartDate,
            'eventHotelEndDate' => $request->eventHotelEndDate,
            'eventHotelRooms' => $request->eventHotelRooms
        ],);

        return back()->with('success', 'Hotel został dodany');
    }





    public function eventHotelDelete(Request $request)
    {

        // dd($request);


        $event = Event::find($request->event_Id);


        $event->hotels()->where('eventHotelNote', $request)->detach($request->hotel_Id);
        return back();
        // $allHotels=Hotel::all();

        // return view('events.edit',compact('event','allHotels'));
    }



    public function customersearch(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('contractors')
                    ->where('name', 'like', '%' . $query . '%')
                    ->orWhere('phone', 'like', '%' . $query . '%')
                    ->orWhere('email', 'like', '%' . $query . '%')
                    ->orWhere('street', 'like', '%' . $query . '%')
                    ->orWhere('nip', 'like', '%' . $query . '%');
            } else {
                $data = DB::table('contractors')->get();
            }

            $total_row = $data->count();

            if ($total_row > 0) {
                foreach ($data as $row) {
                    $output .= '
                    <tr>
                    <td>$row -> name</td>
                    <td>$row -> street</td>
                    </tr>
                    ';
                }
            } else {
                $output = '
                <tr>
                    <td align="center" colspan="5">No Data Found</td>
                </tr>
                ';
            }

            $data = array(
                'table_data' => $output,
                'total_data' => $total_row
            );
        }

        echo json_encode($data);
    }

    public function list(Request $request)
    {
        return view('events.list');
    }
}
