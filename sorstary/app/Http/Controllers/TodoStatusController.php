<?php

namespace App\Http\Controllers;

use App\Models\TodoStatus;
use Illuminate\Http\Request;

class TodoStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = TodoStatus::all();
        return view('todostatus.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('todostatus.create');
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
        $todoStatus = TodoStatus::create($validated);
        return redirect('/todostatus');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TodoStatus  $todoStatus
     * @return \Illuminate\Http\Response
     */
    public function show(TodoStatus $todoStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TodoStatus  $todoStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(TodoStatus $todostatus)
    {
        //
        return view('todostatus.edit', compact('todostatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TodoStatus  $todoStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TodoStatus $todostatus)
    {
        //
        $validated = $request->validate([
            'name' => 'required|max:200',
            'description' => 'nullable|max:3000'
        ]);



        $todostatus->update($validated);
        return redirect('/todostatus');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TodoStatus  $todoStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(TodoStatus $todostatus)
    {
        //
        $todostatus->delete();
        return back();
    }
}
