@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto px-6">
    <div class="mb-6">
        <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Registrations</p>
        <h2 class="text-2xl font-semibold text-gray-900">Registration: {{ $user->name }}</h2>
        <p class="text-sm text-gray-500">Review details and take action on this registration.</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <dt class="text-xs uppercase tracking-wide text-gray-400">Name</dt>
                <dd class="mt-1 text-sm font-medium text-gray-900">{{ $user->name }}</dd>
            </div>
            <div>
                <dt class="text-xs uppercase tracking-wide text-gray-400">Email</dt>
                <dd class="mt-1 text-sm font-medium text-gray-900">{{ $user->email }}</dd>
            </div>
            <div>
                <dt class="text-xs uppercase tracking-wide text-gray-400">Phone</dt>
                <dd class="mt-1 text-sm text-gray-700">{{ $user->phone ?? '-' }}</dd>
            </div>
            <div>
                <dt class="text-xs uppercase tracking-wide text-gray-400">Institution</dt>
                <dd class="mt-1 text-sm text-gray-700">{{ $user->institution ?? '-' }}</dd>
            </div>
            <div>
                <dt class="text-xs uppercase tracking-wide text-gray-400">Education Level</dt>
                <dd class="mt-1 text-sm text-gray-700">{{ $user->education_level ?? '-' }}</dd>
            </div>
            <div>
                <dt class="text-xs uppercase tracking-wide text-gray-400">Package</dt>
                <dd class="mt-1 text-sm text-gray-700">{{ $user->package_type ?? 'tier2' }}</dd>
            </div>
            <div>
                <dt class="text-xs uppercase tracking-wide text-gray-400">Payment Status</dt>
                <dd class="mt-1 text-sm text-gray-700">{{ $user->payment_status ?? '-' }}</dd>
            </div>
            <div>
                <dt class="text-xs uppercase tracking-wide text-gray-400">Registered At</dt>
                <dd class="mt-1 text-sm text-gray-700">{{ $user->created_at }}</dd>
            </div>
        </dl>

        <div class="mt-6 flex flex-wrap gap-3">
            <form action="{{ route('admin.registrations.approve', $user) }}" method="POST" onsubmit="return confirm('Approve this registration?');">
                @csrf
                <button class="inline-flex items-center rounded-md bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700">Approve</button>
            </form>

            <!-- Request correction modal: simple form -->
            <form action="{{ route('admin.registrations.correction', $user) }}" method="POST" onsubmit="return confirm('Send correction request?');">
                @csrf
                <input type="text" name="notes" placeholder="Short note for user" required class="min-w-[200px] rounded-md border border-gray-200 px-3 py-2 text-sm focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-100">
                <button class="inline-flex items-center rounded-md bg-orange-500 px-4 py-2 text-sm font-medium text-white hover:bg-orange-600">Ask for Correction</button>
            </form>

            <form action="{{ route('admin.registrations.reject', $user) }}" method="POST" onsubmit="return confirm('Reject this registration?');">
                @csrf
                <input type="text" name="notes" placeholder="Optional rejection note" class="min-w-[200px] rounded-md border border-gray-200 px-3 py-2 text-sm focus:border-red-400 focus:outline-none focus:ring-2 focus:ring-red-100">
                <button class="inline-flex items-center rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">Reject</button>
            </form>
        </div>
    </div>
</div>
@endsection