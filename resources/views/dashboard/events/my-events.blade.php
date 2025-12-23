@extends('layouts.dashboard')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-sm uppercase tracking-[0.3em] text-gray-400">Calendar</p>
            <h2 class="text-2xl font-semibold text-gray-900">My Events</h2>
            <p class="text-gray-600">Manage your upcoming events and reminders.</p>
        </div>
        <a href="{{ route('events.create') }}"
           class="px-4 py-2 bg-orange-500 text-white rounded-md text-sm font-medium hover:bg-orange-600 transition">
            + Add Event
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @forelse ($events as $event)
        <div class="mb-6 p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">{{ $event->title }}</h3>
                    <p class="text-sm text-gray-500 mb-2">{{ $event->type }}</p>
                    <p class="text-sm text-gray-600">
                        {{ $event->start_time->format('F j, Y H:i') }} to
                        {{ optional($event->end_time)->format('F j, Y H:i') ?? 'N/A' }}
                    </p>
                    @if ($event->reminder)
                        <p class="text-sm text-gray-500 mt-1">Reminder: {{ $event->reminder }}</p>
                    @endif
                    @if ($event->description)
                        <p class="text-sm text-gray-700 mt-2">{{ $event->description }}</p>
                    @endif
                </div>

                <div class="mt-1 flex space-x-2">
                    <a href="{{ route('events.edit', $event->id) }}"
                       class="px-3 py-1 bg-white border border-blue-200 text-blue-600 rounded-md hover:border-blue-300 text-sm font-medium">
                        Edit
                    </a>

                    <form action="{{ route('events.destroy', $event->id) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this event?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-3 py-1 bg-white border border-red-200 text-red-600 rounded-md hover:border-red-300 text-sm font-medium">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p class="text-gray-500">You have no events yet.</p>
    @endforelse
</div>
@endsection
