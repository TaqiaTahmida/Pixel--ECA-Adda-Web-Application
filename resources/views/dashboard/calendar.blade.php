@extends('layouts.dashboard')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css">
    <style>
        .fc .fc-toolbar-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #111827;
        }

        .fc .fc-button {
            background-color: #f97316;
            border-color: #f97316;
            font-weight: 500;
        }

        .fc .fc-button:hover {
            background-color: #ea580c;
            border-color: #ea580c;
        }

        .fc .fc-button:disabled {
            background-color: #fdba74;
            border-color: #fdba74;
            opacity: 1;
        }
    </style>
@endpush

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
        <div>
            <p class="text-sm uppercase tracking-[0.3em] text-gray-400">Schedule</p>
            <h2 class="text-2xl font-semibold text-gray-900">Calendar &amp; Events</h2>
            <p class="text-gray-600">Track your events, deadlines, and sessions in one place.</p>
        </div>

        {{-- Show Add Event button only on My Events tab --}}
        @if($activeTab === 'my-events')
            <a href="{{ route('events.create') }}"
               class="px-4 py-2 bg-orange-500 text-white rounded-md text-sm font-medium hover:bg-orange-600 transition">
                + Add Event
            </a>
        @endif
    </div>

    {{-- Tab Navigation --}}
    <div class="mb-4 border-b border-gray-200">
        <nav class="flex space-x-6 text-sm font-medium text-gray-600">
            <a href="{{ route('calendar.my-events') }}"
               class="{{ $activeTab === 'my-events' ? 'text-orange-600 border-b-2 border-orange-600 pb-3' : 'hover:text-orange-500 pb-3' }}">
                My Events
            </a>
            <a href="{{ route('calendar.deadlines') }}"
               class="{{ $activeTab === 'deadlines' ? 'text-orange-600 border-b-2 border-orange-600 pb-3' : 'hover:text-orange-500 pb-3' }}">
                Deadlines
            </a>
            <a href="{{ route('calendar.sessions') }}"
               class="{{ $activeTab === 'sessions' ? 'text-orange-600 border-b-2 border-orange-600 pb-3' : 'hover:text-orange-500 pb-3' }}">
                Sessions
            </a>
        </nav>
    </div>

    @php
        $calendarEvents = [];
        $tabColors = [
            'my-events' => '#f97316',
            'deadlines' => '#2563eb',
            'sessions' => '#16a34a',
        ];
        $eventColor = $tabColors[$activeTab] ?? '#f97316';

        if (isset($events) && count($events)) {
            foreach ($events as $event) {
                if ($activeTab === 'my-events') {
                    $calendarEvents[] = [
                        'title' => $event->title,
                        'start' => optional($event->start_time)->toIso8601String(),
                        'end' => optional($event->end_time)->toIso8601String(),
                        'description' => $event->description,
                        'eventId' => $event->id,
                        'color' => $eventColor,
                        'textColor' => '#ffffff',
                    ];
                } else {
                    $startDateTime = $event->start->dateTime ?? $event->start->date ?? null;
                    $endDateTime = $event->end->dateTime ?? $event->end->date ?? null;
                    $calendarEvents[] = [
                        'title' => $event->getSummary() ?: 'Event',
                        'start' => $startDateTime,
                        'end' => $endDateTime,
                        'description' => $event->getDescription(),
                        'allDay' => !empty($event->start->date),
                        'color' => $eventColor,
                        'textColor' => '#ffffff',
                    ];
                }
            }
        }
    @endphp

    {{-- Calendar View --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white border border-gray-200 rounded-lg shadow-sm p-4">
            @if(empty($calendarEvents))
                <p class="text-sm text-gray-500 mb-3">No events found for this tab.</p>
            @endif
            <div id="calendar"
                 class="min-h-[550px]"
                 data-active-tab="{{ $activeTab }}"
                 data-edit-route="{{ route('events.edit', ':id') }}"
                 data-delete-route="{{ route('events.destroy', ':id') }}"></div>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
            <h3 class="text-lg font-semibold text-gray-900">Event details</h3>
            <p class="text-sm text-gray-500 mt-1" id="calendar-empty">Select an event to see more details.</p>

            <div id="calendar-details" class="mt-4 hidden">
                <p class="text-base font-semibold text-gray-900" id="calendar-title"></p>
                <p class="text-sm text-gray-600 mt-1" id="calendar-time"></p>
                <p class="text-sm text-gray-700 mt-3" id="calendar-description"></p>
                <div class="mt-4 flex flex-wrap gap-2" id="calendar-actions">
                    <a id="calendar-edit"
                       href="#"
                       class="px-3 py-1 bg-white border border-blue-200 text-blue-600 rounded-md hover:border-blue-300 text-sm font-medium">
                        Edit
                    </a>
                    <form id="calendar-delete-form"
                          action="#"
                          method="POST"
                          onsubmit="return confirm('Delete this event?');">
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
    </div>

    {{-- Back to Dashboard Button --}}
    <div class="mt-8 flex justify-end">
        <a href="{{ route('dashboard.index') }}"
           class="px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-md hover:border-gray-300 transition">
            Back to Dashboard
        </a>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');
            if (!calendarEl) {
                return;
            }

            const activeTab = calendarEl.dataset.activeTab;
            const editRouteTemplate = calendarEl.dataset.editRoute;
            const deleteRouteTemplate = calendarEl.dataset.deleteRoute;
            const calendarEvents = @json($calendarEvents);

            const detailsPanel = document.getElementById('calendar-details');
            const emptyState = document.getElementById('calendar-empty');
            const titleEl = document.getElementById('calendar-title');
            const timeEl = document.getElementById('calendar-time');
            const descriptionEl = document.getElementById('calendar-description');
            const actionsEl = document.getElementById('calendar-actions');
            const editLink = document.getElementById('calendar-edit');
            const deleteForm = document.getElementById('calendar-delete-form');

            const formatDateTime = (date, allDay) => {
                if (!date) {
                    return '';
                }
                const options = allDay
                    ? { dateStyle: 'medium' }
                    : { dateStyle: 'medium', timeStyle: 'short' };
                return new Intl.DateTimeFormat(undefined, options).format(date);
            };

            const formatRange = (event) => {
                const start = formatDateTime(event.start, event.allDay);
                const end = formatDateTime(event.end, event.allDay);
                if (start && end) {
                    return `${start} - ${end}`;
                }
                return start || '';
            };

            const updateDetails = (event) => {
                titleEl.textContent = event.title || 'Untitled event';
                timeEl.textContent = formatRange(event);
                descriptionEl.textContent = event.extendedProps.description || 'No description provided.';
                detailsPanel.classList.remove('hidden');
                emptyState.classList.add('hidden');

                const eventId = event.extendedProps.eventId;
                if (activeTab === 'my-events' && eventId) {
                    actionsEl.classList.remove('hidden');
                    editLink.href = editRouteTemplate.replace(':id', eventId);
                    deleteForm.action = deleteRouteTemplate.replace(':id', eventId);
                } else {
                    actionsEl.classList.add('hidden');
                }
            };

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 'auto',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay',
                },
                events: calendarEvents,
                eventClick: function (info) {
                    info.jsEvent.preventDefault();
                    updateDetails(info.event);
                },
                eventDidMount: function (info) {
                    if (info.event.extendedProps.description) {
                        info.el.setAttribute('title', info.event.extendedProps.description);
                    }
                },
            });

            calendar.render();
        });
    </script>
@endpush
