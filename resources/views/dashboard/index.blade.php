@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-6">
    <h2 class="text-2xl font-semibold text-orange-600 mb-6">
        Welcome back, {{ $user->name }}!
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">

        {{-- Profile Management --}}
        <x-dashboard-card 
            title="Profile Management" 
            text="Manage your info and interests" 
            route="dashboard.profile" 
            button="Manage Profile" 
        />

        {{-- Explore ECAs --}}
        <x-dashboard-card 
            title="Explore ECAs" 
            text="Browse and enroll in opportunities" 
            route="dashboard.ecas" 
            button="View My ECAs" 
        />

        {{-- AI Advisor --}}
        <x-dashboard-card 
            title="AI Advisor" 
            text="Smart recommendations for your growth" 
            route="dashboard.aidash" 
            button="Chat with AI" 
        />

        <x-dashboard-card 
    title="Calendar"
    text="Manage your events and deadlines"
    route="calendar.my-events"
    button="Go to Calendar"
/>

        {{-- Tier 2: One-to-One Session --}}
        @if($user->package_type === 'tier2')
            <x-dashboard-card 
                title="1-to-1 Session" 
                text="Book personalized guidance" 
                route="dashboard.session" 
                button="Book Session" 
            />
        @endif

    </div>
</div>
@endsection
