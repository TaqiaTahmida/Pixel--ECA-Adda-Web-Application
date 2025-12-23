@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-6">
    <div class="flex flex-col gap-2 mb-8">
        <p class="text-sm uppercase tracking-[0.3em] text-gray-400">Overview</p>
        <h1 class="text-3xl font-semibold text-gray-900">Welcome back, {{ $user->name }}!</h1>
        <p class="text-gray-600">Pick where you want to continue today.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        <x-dashboard-card 
            title="Profile Management" 
            text="Manage your info and interests" 
            route="dashboard.profile" 
            button="Manage Profile" 
        />

        <x-dashboard-card 
            title="Explore ECAs" 
            text="Browse and enroll in opportunities" 
            route="dashboard.ecas" 
            button="View My ECAs" 
        />

        <x-dashboard-card 
            title="Queries & Support" 
            text="Send a question or complaint to the admin team" 
            route="dashboard.query.create" 
            button="Send a Query" 
        />

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

        <x-dashboard-card 
            title="Blogs" 
            text="Read, comment, and like posts" 
            route="blogs.index" 
            button="Explore Blogs" 
        />

        <!-- ✅ New Interaction Hub card -->
        <x-dashboard-card 
            title="Interaction Hub" 
            text="Join group chats and share achievements" 
            route="dashboard.hub" 
            button="Go to Hub" 
        />

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
