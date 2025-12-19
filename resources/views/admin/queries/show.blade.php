@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto px-6">
    <div class="mb-6">
        <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Queries</p>
        <h2 class="text-2xl font-semibold text-gray-900">Query from {{ $query->name }}</h2>
        <p class="text-sm text-gray-500">Reply to the user and close the loop.</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 space-y-6">
        <div class="space-y-1">
            <p class="text-xs uppercase tracking-wide text-gray-400">Subject</p>
            <p class="text-sm font-medium text-gray-900">{{ $query->subject ?? 'No subject' }}</p>
        </div>

        <div class="space-y-1">
            <p class="text-xs uppercase tracking-wide text-gray-400">Message</p>
            <p class="text-sm text-gray-700 leading-relaxed">{{ $query->message }}</p>
        </div>

        <form action="{{ route('admin.queries.reply', $query) }}" method="POST" class="space-y-3">
            @csrf
            <label class="text-xs uppercase tracking-wide text-gray-400">Reply</label>
            <textarea name="reply" class="w-full rounded-md border border-gray-200 p-3 text-sm focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-100" placeholder="Write a reply..." rows="5" required></textarea>
            <button class="inline-flex items-center rounded-md bg-orange-500 px-4 py-2 text-sm font-medium text-white hover:bg-orange-600">Send Reply</button>
        </form>
    </div>
</div>
@endsection
