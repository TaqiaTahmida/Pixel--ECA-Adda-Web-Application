@extends('layouts.dashboard')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-8">
    <h2 class="text-2xl font-semibold text-orange-600 mb-6">Edit Event</h2>

    <form action="{{ route('events.update', $event->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Event Title</label>
            <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}"
                   class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring-orange-500 focus:border-orange-500">
        </div>

        {{-- Type --}}
        <div>
            <label for="type" class="block text-sm font-medium text-gray-700">Event Type</label>
            <select name="type" id="type"
                    class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring-orange-500 focus:border-orange-500">
                @foreach(['Workshop', 'Webinar', 'Deadline', 'Other'] as $type)
                    <option value="{{ $type }}" {{ $event->type === $type ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
        </div>

        {{-- Start Time --}}
        <div>
            <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
            <input type="datetime-local" name="start_time" id="start_time"
                   value="{{ old('start_time', $event->start_time->format('Y-m-d\TH:i')) }}"
                   class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring-orange-500 focus:border-orange-500">
        </div>

        {{-- End Time --}}
        <div>
            <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
            <input type="datetime-local" name="end_time" id="end_time"
                   value="{{ old('end_time', optional($event->end_time)->format('Y-m-d\TH:i')) }}"
                   class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring-orange-500 focus:border-orange-500">
        </div>

        {{-- Reminder --}}
        <div>
            <label for="reminder" class="block text-sm font-medium text-gray-700">Reminder</label>
            <input type="text" name="reminder" id="reminder" value="{{ old('reminder', $event->reminder) }}"
                   class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring-orange-500 focus:border-orange-500">
        </div>

        {{-- Description --}}
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="4"
                      class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring-orange-500 focus:border-orange-500">{{ old('description', $event->description) }}</textarea>
        </div>

        {{-- Submit --}}
        <div class="pt-4 flex space-x-4">
            <button type="submit"
                    class="px-6 py-2 bg-orange-600 text-white rounded hover:bg-orange-700 transition">
                Update Event
            </button>
            <a href="{{ route('calendar.my-events') }}"
               class="px-6 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
