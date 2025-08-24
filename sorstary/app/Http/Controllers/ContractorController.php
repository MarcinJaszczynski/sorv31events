<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use App\Models\ContractorType;
use Illuminate\Http\Request;

class ContractorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Contractor::all();
        return view('contractors.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('contractors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dd($request);
        $validated = $request->validate(
            [
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
                'description' => 'nullable|max:3000'

            ]
        );
        $contractor = Contractor::create($validated);

        foreach ($request['contractortype'] as $ctype) {
            $contractorType = ContractorType::find($ctype);
            $contractor->type()->attach($contractorType);
        }

        return redirect('/contractors');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contractor  $contractor
     * @return \Illuminate\Http\Response
     */
    public function show(Contractor $contractor)
    {
        //
        return view('contractors.show', compact('contractor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contractor  $contractor
     * @return \Illuminate\Http\Response
     */
    public function edit(Contractor $contractor)
    {
        //
        return view('contractors.edit', compact('contractor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contractor  $contractor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contractor $contractor)
    {
        //
        $validated = $request->validate([
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
        $contractor->update($validated);

        $contractor->type()->sync($request['contractortype']);

        // foreach ($contractor->type as $ctype) {
        //     foreach ($request['contractortype'] as $rctype) {
        //         if ($ctype->id === $rctype->id) {

        //         } else {

        //         }
        //     }

        // }


        return redirect('/contractors');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contractor  $contractor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contractor $contractor)
    {
        //
        $contractor->delete();
        // $data = Contractor::all();
        return back()->withErrors([]);
    }

    public function get_all()
    {
        $contractors = Contractor::getAll();
        return compact('contractors');
    }



    public function getcontractor(Request $request)
    {
        if ($request->keyword != '' and $request->contractortype != '') {
            $type = $request->contractortype;
            $contractors = Contractor::with('type')
                ->whereHas('type', function ($q) use ($type) {
                    $q->where('contractor_types.id', $type);
                })
                ->where('name', 'LIKE', '%' . $request->keyword . '%')
                ->get();
        } elseif ($request->keyword == '') {
            $contractors = Contractor::with('type')
                ->where('name', 'LIKE', '%' . $request->keyword . '%')
                ->orWhere('firstname', 'LIKE', '%' . $request->keyword . '%')
                ->orWhere('surname', 'LIKE', '%' . $request->keyword . '%')
                ->orWhere('phone', 'LIKE', '%' . $request->keyword . '%')
                ->orWhere('email', 'LIKE', '%' . $request->keyword . '%')
                ->get();
        }




        return response()->json([
            'contractors' => $contractors
        ]);
    }

            public function list(Request $request)
    {
        return view('contractors.list');
    }
}
