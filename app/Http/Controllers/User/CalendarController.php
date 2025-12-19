<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\GoogleCalendarService;
use App\Models\Event;

class CalendarController extends Controller
{
    // Tab 1: My Events (user-created)
    public function myEvents()
{
    $user = Auth::user();
    $events = Event::where('user_id', $user->id)->latest()->get();

    return view('dashboard.calendar', [
        'activeTab' => 'my-events',
        'user' => $user,
        'events' => $events,
    ]);
}

    // Tab 2: Deadlines Calendar (Google Calendar via service account)
    public function deadlines(GoogleCalendarService $calendarService)
    {
        $user = Auth::user();
        $calendarId = 'b418eefa1e9269a32fe9c55e7f3efe6e3e4c79fc6050cd2c529e194771f4f01d@group.calendar.google.com';

        $events = $calendarService->getCalendarEvents($calendarId);

        return view('dashboard.calendar', [
            'activeTab' => 'deadlines',
            'user' => $user,
            'events' => $events,
        ]);
    }

    // Tab 3: Sessions Calendar (Google Calendar via service account)
    public function sessions(GoogleCalendarService $calendarService)
    {
        $user = Auth::user();
        $calendarId = '9c3faa2bd73338203d93ed5fe8af10f53b129a5afc824fac74ee029bc1c78095@group.calendar.google.com';

        $events = $calendarService->getCalendarEvents($calendarId);

        return view('dashboard.calendar', [
            'activeTab' => 'sessions',
            'user' => $user,
            'events' => $events,
        ]);
    }
}
?>