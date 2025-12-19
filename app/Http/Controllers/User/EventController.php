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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:Workshop,Webinar,Deadline,Other',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'reminder' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        Event::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'type' => $validated['type'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'] ?? null,
            'reminder' => $validated['reminder'] ?? null,
            'description' => $validated['description'] ?? null,
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

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:Workshop,Webinar,Deadline,Other',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'reminder' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $event->update([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'] ?? null,
            'reminder' => $validated['reminder'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);

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
?>
