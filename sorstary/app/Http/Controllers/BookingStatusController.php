<?php

namespace App\Http\Controllers;

use App\Models\BookingStatus;
use Illuminate\Http\Request;

class BookingStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = BookingStatus::all();
        return view('bookingstatus.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('bookingstatus.create');
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
        $validated = $request->validate(
            [
                'name' => 'required|max:200',
                'description' => 'nullable|max:3000'

            ]
        );
        $BookingStatus = BookingStatus::create($validated);
        return redirect('/bookingstatus');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BookingStatus  $bookingStatus
     * @return \Illuminate\Http\Response
     */
    public function show(BookingStatus $bookingStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BookingStatus  $bookingStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(BookingStatus $bookingStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BookingStatus  $bookingStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BookingStatus $bookingStatus)
    {
        //
        $validated = $request->validate(
            [
                'name' => 'required|max:200',
                'description' => 'nullable|max:3000'

            ]
        );
        $BookingStatus = BookingStatus::create($validated);
        return redirect('/bookingstatus');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BookingStatus  $bookingStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookingStatus $bookingStatus)
    {
        //
    }
}
