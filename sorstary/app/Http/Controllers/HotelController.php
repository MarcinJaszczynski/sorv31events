<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Hotel;



class HotelController extends Controller


{
    //
    public function store(Request $request)
    {



        $this->validate($request, [
            'hotelName' => 'required',
            'hotelStreet'=> 'required',
            'hotelCity'=> 'required',
            'hotelRegion'=> 'required'

        ]);

        $input = $request->except(['_token']);
    
        Hotel::create($input);
    
        return redirect()->back()
            ->with('success','Hotel dodany pomyślnie');
    }
}
