@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-6">
    <div class="flex flex-col gap-2 mb-6">
        <p class="text-sm uppercase tracking-[0.3em] text-gray-400">Account</p>
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-gray-900">Profile &amp; Settings</h2>
            <a href="{{ route('dashboard.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-md shadow-sm hover:border-gray-300 transition">
                Back to Dashboard
            </a>
        </div>
        <p class="text-gray-600">Keep your information and security details up to date.</p>
    </div>

    {{-- Tab Navigation --}}
    <div class="mb-6 border-b border-gray-200">
        <nav class="flex space-x-6 text-sm font-medium text-gray-600">
            <a href="{{ route('dashboard.profile') }}"
               class="{{ request()->routeIs('dashboard.profile') ? 'text-orange-600 border-b-2 border-orange-600 pb-3' : 'hover:text-orange-500 pb-3' }}">
                Personal Info
            </a>
            <a href="{{ route('dashboard.subscription') }}"
               class="{{ request()->routeIs('dashboard.subscription') ? 'text-orange-600 border-b-2 border-orange-600 pb-3' : 'hover:text-orange-500 pb-3' }}">
                Subscription
            </a>
            <a href="{{ route('dashboard.security') }}"
               class="{{ request()->routeIs('dashboard.security') ? 'text-orange-600 border-b-2 border-orange-600 pb-3' : 'hover:text-orange-500 pb-3' }}">
                Security
            </a>
        </nav>
    </div>

    {{-- Section Content --}}
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
        @yield('profile-section')
    </div>
</div>
@endsection
