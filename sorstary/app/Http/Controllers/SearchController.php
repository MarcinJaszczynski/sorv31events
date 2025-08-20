<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;

use App\Models\Event;
use App\Models\Todo;
use App\Models\Note;


use Illuminate\Http\Request;

class SearchController extends Controller
{
    //
    public function latestActivity(Request $request)
    {

        // $latestActivities = [];

        $events = Event::with('author')->orderBy('created_at', 'desc')->limit(10)->get();

        foreach ($events as $event) {
            $event['kind'] = 'event';
        }

        $todos = Todo::with('principal', 'event', 'executor')->orderBy('created_at', 'desc')->limit(10)->get();

        foreach ($todos as $todo) {
            $todo['kind'] = 'todo';
        }
        $notes = Note::with('todo')->orderBy('created_at', 'desc')->limit(10)->get();

        foreach ($notes as $note) {
            $note['kind'] = 'note';
        }
        $latestActivities = $events;
        $latestActivities = $latestActivities->merge($notes);
        $latestActivities = $latestActivities->merge($todos);

        $latestActivities = $latestActivities->sortByDesc('created_at')->values();
        $latestActivities = $latestActivities->take(10);

        return response()->json(['latestActivities' => $latestActivities, 'todos' => $todos]);
    }

    public function todoSearch(Request $request)
    {
        dd('funkcja');
        $todos = 'todosy';
        return response()->json(['todos' => $todos]);
    }

    public function eventSearch(Request $request)
    {
        dd($request);
    }
}
