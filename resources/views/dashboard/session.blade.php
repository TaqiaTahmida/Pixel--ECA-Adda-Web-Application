@extends('layouts.dashboard')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-sm uppercase tracking-[0.3em] text-gray-400">Sessions</p>
            <h2 class="text-2xl font-semibold text-gray-900">Choose Your 1-to-1 Instructor</h2>
            <p class="text-gray-600">
                Pick an instructor to view available 30-minute slots.
            </p>
        </div>
        <a href="{{ route('dashboard.index') }}"
           class="px-3 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-md shadow-sm hover:border-gray-300 transition">
            Back to Dashboard
        </a>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
        <div class="mb-4">
            <p class="text-sm text-gray-600">Select an instructor to continue.</p>
            <p class="text-sm text-gray-500">You will be taken to the booking page after choosing.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('dashboard.session.instructor', ['instructor' => 1]) }}"
               class="group block border border-gray-200 rounded-lg p-4 hover:border-orange-300 hover:shadow-sm transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Instructor 1</h3>
                        <p class="text-sm text-gray-500">Book a 30-minute one-to-one session.</p>
                    </div>
                    <span class="text-sm font-medium text-orange-600 group-hover:translate-x-1 transition">Select</span>
                </div>
            </a>

            <a href="{{ route('dashboard.session.instructor', ['instructor' => 2]) }}"
               class="group block border border-gray-200 rounded-lg p-4 hover:border-orange-300 hover:shadow-sm transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Instructor 2</h3>
                        <p class="text-sm text-gray-500">Book a 30-minute one-to-one session.</p>
                    </div>
                    <span class="text-sm font-medium text-orange-600 group-hover:translate-x-1 transition">Select</span>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
