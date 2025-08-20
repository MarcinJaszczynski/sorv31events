<?php

namespace App\Http\Controllers;

use App\Models\ContractorType;
use Illuminate\Http\Request;

class ContractorTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = ContractorType::all();
        return view('contractorstypes.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('contractorstypes.create');
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
        $validated = $request->validate([
            'name' => 'required|max:200'
        ]);
        $contractorType = ContractorType::create($validated);
        return redirect('/contractorstypes');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContractorType  $contractorType
     * @return \Illuminate\Http\Response
     */
    public function show(ContractorType $contractorType)
    {
        //


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContractorType  $contractorType
     * @return \Illuminate\Http\Response
     */
    public function edit(ContractorType $contractorType)
    {
        //
        return view('contractorstypes.edit', compact('contractorType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContractorType  $contractorType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContractorType $contractorType)
    {
        //
        $validated = $request->validate([
            'name' => 'required|max:200',
        ]);
        $contractorType->update($validated);
        return redirect('/contractorstypes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContractorType  $contractorType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContractorType $contractorType)
    {
        //
        $contractorType->delete();
        return back();
    }
}
