@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-sm uppercase tracking-[0.3em] text-gray-400">Calendar</p>
            <h2 class="text-2xl font-semibold text-gray-900">Create New Event</h2>
            <p class="text-gray-600">Add a new event to your calendar.</p>
        </div>
        <a href="{{ route('calendar.my-events') }}"
           class="px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-md shadow-sm hover:border-gray-300 transition">
            Back to Calendar
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('events.store') }}" method="POST" class="space-y-6 bg-white border border-gray-200 rounded-lg shadow-sm p-6">
        @csrf

        {{-- Title --}}
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Event Title</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}"
                   class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring-orange-500 focus:border-orange-500">
        </div>

        {{-- Type --}}
        <div>
            <label for="type" class="block text-sm font-medium text-gray-700">Event Type</label>
            <select name="type" id="type"
                    class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring-orange-500 focus:border-orange-500">
                <option value="">Select type</option>
                @foreach(['Workshop', 'Webinar', 'Deadline', 'Other'] as $type)
                    <option value="{{ $type }}" {{ old('type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
        </div>

        {{-- Start Time --}}
        <div>
            <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
            <input type="datetime-local" name="start_time" id="start_time" value="{{ old('start_time') }}"
                   class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring-orange-500 focus:border-orange-500">
        </div>

        {{-- End Time --}}
        <div>
            <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
            <input type="datetime-local" name="end_time" id="end_time" value="{{ old('end_time') }}"
                   class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring-orange-500 focus:border-orange-500">
        </div>

        {{-- Reminder --}}
        <div>
            <label for="reminder" class="block text-sm font-medium text-gray-700">Reminder</label>
            <input type="text" name="reminder" id="reminder" value="{{ old('reminder') }}"
                   placeholder="e.g. 1 day before"
                   class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring-orange-500 focus:border-orange-500">
        </div>

        {{-- Description --}}
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="4"
                      class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring-orange-500 focus:border-orange-500">{{ old('description') }}</textarea>
        </div>

        {{-- Submit --}}
        <div class="pt-4">
            <button type="submit"
                    class="px-6 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700 transition">
                Save Event
            </button>
        </div>
    </form>
</div>
@endsection
