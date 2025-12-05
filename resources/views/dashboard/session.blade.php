@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h3>1-to-1 Session Booking</h3>

    <p>As a Tier 2 subscriber, you can book personalized sessions with mentors.</p>

    <form action="#" method="POST">
        @csrf
        <div class="mb-3">
            <label>Select Date</label>
            <input type="date" name="session_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Select Time</label>
            <input type="time" name="session_time" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Book Session</button>
    </form>
</div>
@endsection
