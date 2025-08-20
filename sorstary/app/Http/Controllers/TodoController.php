<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;


use App\Models\Todo;
use App\Models\User;
use App\Models\Event;
use App\Models\TodoStatus;
use App\Models\Contractor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $q = Todo::query();

        if (!empty($request['urgent'])) {
            $q->where('urgent', $request['urgent']);
        }
        if (!empty($request['executor'])) {
            $q->where('executor_id', $request['executor']);
        }
        if (!empty($request['status'])) {
            $q->where('status_id', $request['status']);
        }
        $q->where('status_id','!=',5);
        $data = $q->orderBy('last_update','desc')->get();


        return view('todo.index', compact('data'));
    }

    public function indexDone(){
        $data = Todo::where('status_id', '5')->orderBy('last_update','desc')->get();
        return view('todo.indexdone', compact('data'));
    }

    public function ordersindex(Request $request)
    {
        $data = 'aaa';
        return view('todo.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $statuses = TodoStatus::all();
        $contractors = Contractor::all();
        $executors = User::all();
        return view('todo.create', compact('statuses', 'contractors', 'executors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required|max:200',
                'event_id' => 'nullable',
                'deadline' => 'nullable',
                'description' => 'nullable|string|max:10000',
                'principal_id' => 'integer',
                'executor_id' => 'integer',
                'private' => 'nullable|boolean',
                'urgent' => 'nullable|boolean',
                'status_id' => 'integer'
            ]
        );



        $validated['last_update'] = Carbon::now()->toDateTimeString();
        // $validated['deadline'] = $request['deadline'];
        // dd($request['deadline']);



        $todo = Todo::create($validated);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        //
        return view('todo.show', compact('todo'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        $statuses = TodoStatus::all();
        $contractors = Contractor::all();
        $users = User::all();
        return view('todo.edit', compact('todo', 'statuses', 'users', 'contractors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        // dd($request, $todo);

        $input = $request->all();
        $todo['last_update'] = Carbon::now()->toDateTimeString();
        $todo['deadline'] = $request['deadline'];
        $todo->fill($input)->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        //
        $todo->delete();
        return view('/dashboard');
    }
}