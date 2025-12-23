<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Session;

class OneToOneController extends Controller
{
    // Show booking form
    public function create()
    {
        return view('dashboard.session');
    }

    // Show instructor-specific booking page
    public function showInstructor(string $instructor)
    {
        $instructors = [
            '1' => 'Instructor 1',
            '2' => 'Instructor 2',
        ];

        if (!array_key_exists($instructor, $instructors)) {
            return redirect()->route('dashboard.session')
                ->with('status', 'Please choose an instructor to continue.');
        }

        return view('dashboard.session-instructor', [
            'instructor' => $instructor,
            'instructorLabel' => $instructors[$instructor],
        ]);
    }

    // Handle booking submission
    public function store(Request $request)
    {
        $validated = $request->validate([
            'session_date' => 'required|date',
            'session_time' => 'required',
        ]);

        // Combine date + time into a datetime
        $start = \Carbon\Carbon::parse($validated['session_date'].' '.$validated['session_time']);

        Session::create([
            'user_id'       => auth()->id(),
            'invitee_email' => auth()->user()->email,
            'status'        => 'scheduled',
            'start_time'    => $start,
            'end_time'      => $start->copy()->addHour(), // default 1 hour
            'event_uuid'    => uniqid('sess_'), // placeholder until Calendly sync
        ]);

        return redirect()->route('dashboard.session')
            ->with('status', 'Your session has been booked!');
    }
}
?>
