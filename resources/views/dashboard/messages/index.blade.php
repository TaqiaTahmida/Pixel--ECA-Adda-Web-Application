@extends('layouts.dashboard')

@section('content')
<div class="max-w-5xl mx-auto px-6">
    <div class="mb-6">
        <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Messages</p>
        <h2 class="text-2xl font-semibold text-gray-900">Admin Messages</h2>
        <p class="text-sm text-gray-500">Updates sent by the admin team.</p>
    </div>

    <div class="space-y-4">
        @forelse($messages as $message)
            <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                    <div class="flex-1">
                        <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500">
                            <span>Admin</span>
                            <span>{{ optional($message->created_at)->format('d M, Y h:i A') }}</span>
                            @if($message->read_at === null)
                                <span class="inline-flex items-center rounded-full bg-red-50 px-2 py-0.5 text-[10px] font-semibold text-red-600">Unread</span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-[10px] font-semibold text-gray-500">Read</span>
                            @endif
                        </div>
                        <p class="mt-2 text-sm text-gray-800">{{ $message->message }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        @if($message->read_at === null)
                            <form action="{{ route('dashboard.messages.read', $message) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="inline-flex items-center rounded-md border border-orange-200 px-3 py-1.5 text-xs font-semibold text-orange-600 hover:bg-orange-50">
                                    Mark read
                                </button>
                            </form>
                        @endif
                        <form action="{{ route('dashboard.messages.delete', $message) }}" method="POST"
                              onsubmit="return confirm('Delete this message?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center rounded-md border border-gray-200 px-3 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-50">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white border border-gray-200 rounded-lg p-6 text-center text-sm text-gray-500">
                No messages yet.
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $messages->links() }}
    </div>
</div>
@endsection
