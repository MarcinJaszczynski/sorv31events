<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventPayment;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EventPaymentController extends Controller
{

    public function index(Request $request)
    {
        $data = EventPayment::where('event_id', $request->event_id)->get();
        $event = Event::find($request->event_id);
        return view('eventPayments.index', compact('data', 'event'));
    }

    public function editPayment($id)
    {
    }

    public function addPaymentContractor(Request $request)
    {
        $payment = EventPayment::findOrFail($request->payment_id);
        $payment['contractor_id'] = $request->contractor_id;
        $payment->update();
        return back();
    }

    public function getPayment(Request $request)
    {
        $payment = EventPayment::findOrFail($request->id);
        // return response('payment');
        // $payment = EventPayment::query()->find($request->id);
        // if (!$payment) {
        //     return response()->json(['success' => false, 'message' => 'Brak płatności']);
        // }
        return response()->json(['success' => true, 'payment' => $payment]);
    }

    // Start - funkcje podstawowe


    public function store(Request $request)
    {
        $this->validate($request, [
            'paymentName' => 'required',
        ]);

        $input = $request->except(['_token']);


        EventPayment::create($input);

        return back();
    }

    public function storeElementPayment(Request $request)
    {
        $this->validate($request, [
            'paymentName' => 'required',
        ]);

        $input = $request->except(['_token']);
        EventPayment::create($input);
        $event = Event::find($request->event_id);
        $allHotels = Hotel::all();
        return redirect()->route('events.edit', compact('event', 'allHotels'));

    }

    public function update(Request $request)
    {
        $data = EventPayment::findOrFail($request->id);
        if ($request->contractor_id === '0') {
            $data->contractor_id = null;
        }
        $data->update($request->all());
        return back();
    }

    public function destroy($id)
    {
        $payment = EventPayment::findOrFail($id);
        $payment->delete();
        return back();
    }
}