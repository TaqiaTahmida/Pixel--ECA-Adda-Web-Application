@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-orange-600">Calendar & Events</h2>

        {{-- Show Add Event button only on My Events tab --}}
        @if($activeTab === 'my-events')
            <a href="{{ route('events.create') }}"
               class="px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600 transition">
                + Add Event
            </a>
        @endif
    </div>

    {{-- Tab Navigation --}}
    <div class="mb-4 border-b border-gray-200">
        <nav class="flex space-x-6 text-sm font-medium text-gray-600">
            <a href="{{ route('calendar.my-events') }}"
               class="{{ $activeTab === 'my-events' ? 'text-orange-600 border-b-2 border-orange-600 pb-2' : 'hover:text-orange-500' }}">
               My Events
            </a>
            <a href="{{ route('calendar.deadlines') }}"
               class="{{ $activeTab === 'deadlines' ? 'text-orange-600 border-b-2 border-orange-600 pb-2' : 'hover:text-orange-500' }}">
               Deadlines
            </a>
            <a href="{{ route('calendar.sessions') }}"
               class="{{ $activeTab === 'sessions' ? 'text-orange-600 border-b-2 border-orange-600 pb-2' : 'hover:text-orange-500' }}">
               Sessions
            </a>
        </nav>
    </div>

    {{-- Tab Content --}}
    <div class="space-y-4">
        @if(isset($events) && count($events))
            @foreach($events as $event)
                <div class="p-4 border rounded shadow-sm">
                    {{-- My Events Tab --}}
                    @if($activeTab === 'my-events')
                        <h3 class="text-lg font-semibold text-gray-800">{{ $event->title }}</h3>
                        <p class="text-sm text-gray-600">
                            {{ $event->start_time }} → {{ $event->end_time }}
                        </p>
                        @if($event->description)
                            <p class="mt-1 text-sm text-gray-700">{{ $event->description }}</p>
                        @endif

                        <div class="mt-2 flex space-x-2">
                            <a href="{{ route('events.edit', $event->id) }}"
                               class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                                Edit
                            </a>
                            <form action="{{ route('events.destroy', $event->id) }}" method="POST"
                                  onsubmit="return confirm('Delete this event?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                                    Delete
                                </button>
                            </form>
                        </div>

                    {{-- Deadlines / Sessions Tabs --}}
                    @else
                        <h3 class="text-lg font-semibold text-gray-800">{{ $event->getSummary() }}</h3>
                        <p class="text-sm text-gray-600">
                            {{ $event->start->dateTime ?? $event->start->date }}
                            → {{ $event->end->dateTime ?? $event->end->date }}
                        </p>
                        @if($event->getDescription())
                            <p class="mt-1 text-sm text-gray-700">{{ $event->getDescription() }}</p>
                        @endif
                    @endif
                </div>
            @endforeach
        @else
            <p class="text-gray-500">No events found for this tab.</p>
        @endif
    </div>

    {{-- Back to Dashboard Button --}}
    <div class="mt-8 flex justify-end">
        <a href="{{ route('dashboard.index') }}"
           class="px-4 py-2 bg-gray-200 text-gray-800 text-sm font-medium rounded hover:bg-gray-300 transition">
            ← Back to Dashboard
        </a>
    </div>
</div>
@endsection
