<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function create()
{
    return view('dashboard.events.create');
}

public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'type' => 'required|in:Workshop,Webinar,Deadline,Other',
        'start_time' => 'required|date',
        'end_time' => 'nullable|date|after_or_equal:start_time',
        'reminder' => 'nullable|string',
        'description' => 'nullable|string',
    ]);

    Event::create([
        'user_id' => Auth::id(),
        'title' => $request->title,
        'type' => $request->type,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'reminder' => $request->reminder,
        'description' => $request->description,
    ]);

    return redirect()->route('calendar.my-events')->with('success', 'Event created successfully!');
}

public function index()
{
    $events = Event::where('user_id', Auth::id())->latest()->get();
    return view('dashboard.events.my-events', compact('events'));
}
 public function edit(Event $event)
    {
        // Ensure only the owner can edit
        if ($event->user_id !== Auth::id()) {
            abort(403);
        }

        return view('dashboard.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        if ($event->user_id !== Auth::id()) {
            abort(403);
            }

        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:Workshop,Webinar,Deadline,Other',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'reminder' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $event->update($request->all());

        return redirect()->route('calendar.my-events')->with('success', 'Event updated successfully!');
    }

    public function destroy(Event $event)
    {
        if ($event->user_id !== Auth::id()) {
            abort(403);
        }

        $event->delete();
        return redirect()->route('calendar.my-events')->with('success', 'Event deleted successfully!');
    }
}
