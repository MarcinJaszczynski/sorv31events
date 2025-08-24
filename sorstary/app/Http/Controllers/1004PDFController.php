<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventElement;

use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generatePilotPDF(Request $request)
    {
        $event = Event::find($request->eventId);
        $pdf = PDF::loadView('reports.pilotpdf', compact('event'));
        return $pdf->stream('teczkaPilota.pdf');
    }

    public function generateHotelpdf(Request $request)
    {
        $event = Event::find($request->eventId);
        $pdf = PDF::loadView('reports.hotelpdf', compact('event'));
        return $pdf->stream('agendaDlaHotelu.pdf');
    }

    public function generateDriverpdf(Request $request)
    {
        $event = Event::find($request->eventId);
        $pdf = PDF::loadView('reports.driverPdf', compact('event'));
        return $pdf->stream('infoDlaKierowcy.pdf');
    }

    public function generateBriefcasepdf(Request $request)
    {
        $event = Event::find($request->eventId);
        $pdf = PDF::loadView('reports.briefcasePdf', compact('event'));
        return $pdf->stream('teczkaImprezy.pdf');
    }

    public function generateContractpdf(Request $request)
    {
        $event = Event::find($request->eventId);

        // $com = compact('request', 'event');
        // dd($com);

        $pdf = PDF::loadView('reports.contractPdf', compact('request', 'event'));


        return $pdf->stream('Umowa.pdf');
    }
}
