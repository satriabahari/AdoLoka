<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        // Ambil semua event mendatang beserta media-nya
        $events = Event::with('media')->upcoming()->get();

        return view('events', compact('events'));
    }

    public function show(Event $event) // pakai slug (getRouteKeyName)
    {
        $event->load('media'); // biar tidak N+1
        return view('event-detail', compact('event'));
    }
}
