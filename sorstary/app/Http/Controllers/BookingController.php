<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\EventElement;
use App\Models\EventContractor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = EventElement::where('booking', '0')
            ->orWhere('booking', '1')
            ->orWhere('booking', '2')
            ->orWhere('booking', '3')
            ->orWhere('booking', '4')
            ->orderBy('eventElementStart', 'ASC')
            ->orderBy('eventIdinEventElements', 'ASC')
            ->get();
        // dd($data);
        return view('bookings.index', compact('data'));
    }

    public function getBookings($query)
    {
        $todayDate = Carbon::today();
        if ($query === '5') {
            $response = DB::select('
            select U.* 
            from event_elements U
            inner join event_contractors UP
            where 
            U.id = UP.eventelement_id
            AND
            U.eventElementEnd >= NOW()
            AND
            (UP.contractortype_id = 6  
            OR
            UP.contractortype_id = 7)
            ORDER BY
            U.eventElementStart     
            ');
            $data = EventElement::hydrate($response);
            // $data = EventElement::with(['bookingType'])->where('booking', '!=', NULL)->get();
            // $data = EventContractor::whereHas(['eventelement'])->get();
            // dd($data);
            return view('bookings.index', compact('data'));

        } elseif ($query === '6') {

            $response = DB::select('
            select U.* 
            from event_elements U
            inner join event_contractors UP
            where             
            U.id = UP.eventelement_id
            AND
            UP.contractortype_id = 1
            AND
            U.eventElementEnd >= NOW()      
            ORDER BY
            U.eventElementStart');
            $data = EventElement::hydrate($response);

            return view('bookings.index', compact('data'));
        } else {
            $data = EventElement::where('booking', $query)
                ->whereDate('eventElementEnd', '>=', $todayDate)
                ->orderBy('eventElementStart', 'ASC')
                ->orderBy('eventIdinEventElements', 'ASC')
                ->get();
            return view('bookings.index', compact('data'));
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        //
    }
}