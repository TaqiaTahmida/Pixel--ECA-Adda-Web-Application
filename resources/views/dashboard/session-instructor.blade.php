@extends('layouts.dashboard')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <p class="text-sm uppercase tracking-[0.3em] text-gray-400">Sessions</p>
            <h2 class="text-2xl font-semibold text-gray-900">Book Your 1-to-1 Session</h2>
            <p class="text-gray-600">
                You are booking with {{ $instructorLabel }}.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard.session') }}"
               class="px-3 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-md shadow-sm hover:border-gray-300 transition">
                Change Instructor
            </a>
            <a href="{{ route('dashboard.index') }}"
               class="px-3 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-md shadow-sm hover:border-gray-300 transition">
                Back to Dashboard
            </a>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Powered by Calendly</p>
                <p class="text-sm text-gray-500">Times automatically adjust to your timezone.</p>
            </div>
            <span class="text-sm font-medium text-orange-600">{{ $instructorLabel }}</span>
        </div>

        @if ($instructor === '1')
            <!-- Calendly inline widget begin -->
            <div class="calendly-inline-widget" data-url="https://calendly.com/eca_adda_instructor1/30min" style="min-width:320px;height:700px;"></div>
            <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>
            <!-- Calendly inline widget end -->
        @elseif ($instructor === '2')
            <!-- Calendly inline widget begin -->
            <div class="calendly-inline-widget" data-url="https://calendly.com/eca_adda_instructor2/30min" style="min-width:320px;height:700px;"></div>
            <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>
            <!-- Calendly inline widget end -->
        @endif
    </div>
</div>
@endsection
