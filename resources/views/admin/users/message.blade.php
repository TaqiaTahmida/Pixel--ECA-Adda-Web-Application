@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto px-6">
    <div class="mb-6">
        <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Users</p>
        <h2 class="text-2xl font-semibold text-gray-900">Message {{ $user->name }}</h2>
        <p class="text-sm text-gray-500">Send a quick note to this user.</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 space-y-6">
        <div class="text-sm text-gray-600">
            <div class="font-semibold text-gray-900">{{ $user->name }}</div>
            <div>{{ $user->email }}</div>
        </div>

        <form action="{{ route('admin.users.message.send', $user) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                <textarea id="message" name="message" rows="4" required
                          class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-orange-500 focus:ring-orange-500"></textarea>
            </div>
            <div class="flex items-center gap-3">
                <button type="submit"
                        class="inline-flex items-center rounded-md bg-orange-500 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-600">
                    Send
                </button>
                <a href="{{ route('admin.users.index') }}"
                   class="inline-flex items-center rounded-md border border-gray-200 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Back to list
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
