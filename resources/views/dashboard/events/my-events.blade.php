@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-8">
    <h2 class="text-2xl font-semibold text-orange-600 mb-6">My Events</h2>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @forelse ($events as $event)
        <div class="mb-6 p-4 bg-white rounded shadow-sm border border-gray-200">
            <h3 class="text-lg font-bold text-gray-800">{{ $event->title }}</h3>
            <p class="text-sm text-gray-500 mb-2">{{ $event->type }}</p>
            <p class="text-sm text-gray-600">
                {{ $event->start_time->format('F j, Y H:i') }} → 
                {{ optional($event->end_time)->format('F j, Y H:i') ?? 'N/A' }}
            </p>
            @if ($event->reminder)
                <p class="text-sm text-gray-500 mt-1">Reminder: {{ $event->reminder }}</p>
            @endif
            @if ($event->description)
                <p class="text-sm text-gray-700 mt-2">{{ $event->description }}</p>
            @endif

            <div class="mt-4 flex space-x-4">
                <a href="{{ route('events.edit', $event->id) }}"
                   class="px-4 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                    Edit
                </a>

                <form action="{{ route('events.destroy', $event->id) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this event?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-4 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    @empty
        <p class="text-gray-500">You have no events yet.</p>
    @endforelse
</div>
@endsection
