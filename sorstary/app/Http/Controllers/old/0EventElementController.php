<?php

namespace App\Http\Controllers;

use App\Models\EventElement;


use Illuminate\Http\Request;

class EventElementController extends Controller
{
    //
    public function index()
    {
        //
        $data = EventElement::all();
        return view('eventelements.index', compact('data'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'element_name' => 'required',
        ]);

        $input = $request->except(['_token']);

        EventElement::create($input);

        return back();
    }

    public function getAllElements()
    {
        $elements = EventElement::all();
        // if (!$elements) {
        //     return response()->json(['success' => false, 'message' => 'elemnet does not exist']);
        // }
        return response()->json(['success' => true, 'elements' => $elements]);
    }

    public function edit(EventElement $eventelement)
    {
        return view('eventelements.edit', compact('eventelement'));
    }

    public function destroy(EventElement $eventelement)
    {
        $eventelement->delete();
        return back();
    }



    public function getElement($id)
    {
        $element = EventElement::query()->find($id);
        if (!$element) {
            return response()->json(['success' => false, 'message' => 'elemnet does not exist']);
        }
        return response()->json(['success' => true, 'element' => $element]);
    }
}