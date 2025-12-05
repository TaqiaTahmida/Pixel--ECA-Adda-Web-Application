@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-6">
    {{-- Header with title and back button --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-orange-600">Profile Management</h2>
        <a href="{{ route('dashboard.index') }}"
           class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition">
           ← Back to Dashboard
        </a>
    </div>

    {{-- Tab Navigation --}}
    <div class="mb-4 border-b border-gray-200">
        <nav class="flex space-x-4 text-sm font-medium text-gray-600">
            <a href="{{ route('dashboard.profile') }}"
               class="{{ request()->routeIs('dashboard.profile') ? 'text-orange-600 border-b-2 border-orange-600' : 'hover:text-orange-500' }}">
               Personal Info
            </a>
            <a href="{{ route('dashboard.subscription') }}"
               class="{{ request()->routeIs('dashboard.subscription') ? 'text-orange-600 border-b-2 border-orange-600' : 'hover:text-orange-500' }}">
               Subscription
            </a>
            <a href="{{ route('dashboard.security') }}"
               class="{{ request()->routeIs('dashboard.security') ? 'text-orange-600 border-b-2 border-orange-600' : 'hover:text-orange-500' }}">
               Security
            </a>
        </nav>
    </div>

    {{-- Section Content --}}
    @yield('profile-section')
</div>
@endsection
