<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public $events = [];

    public function __construct()
    {
        $this->events = [
            1 => ['name' => 'Meeting PHP', 'date' => '27/07/2026'],
            2 => ['name' => 'Meeting Laravel', 'date' => '28/07/2026'],
            3 => ['name' => 'Meeting JS', 'date' => '29/07/2026'],
        ];
    }

    public function index()
    {
        return view('pages.events', [
            'events' => $this->events,
        ]);
    }

    public function show($id)
    {
        if(! array_key_exists($id, $this->events)) {
            abort(404);
        }


        return view('pages.event', [
            'event' => $this->events[$id],
        ]);
    }
}
