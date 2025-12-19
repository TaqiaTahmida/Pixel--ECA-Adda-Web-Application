@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Registrations</p>
            <h2 class="text-2xl font-semibold text-gray-900">Pending Registrations</h2>
        </div>
        <span class="text-sm text-gray-500">{{ $users->total() }} pending</span>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @foreach($users as $user)
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                    </div>
                    <span class="inline-flex items-center rounded-full bg-orange-50 px-3 py-1 text-xs font-medium text-orange-600">
                        {{ $user->package_type ?? 'tier2' }}
                    </span>
                </div>

                <div class="mt-4 text-sm text-gray-600 space-y-1">
                    <p><span class="font-medium text-gray-700">Registered:</span> {{ $user->created_at->format('d M, Y H:i') }}</p>
                    <p><span class="font-medium text-gray-700">Status:</span> {{ $user->registration_status }}</p>
                </div>

                <div class="mt-5 flex flex-wrap gap-3">
                    <a href="{{ route('admin.registrations.show', $user) }}" class="inline-flex items-center rounded-md border border-gray-200 px-3 py-2 text-sm font-medium text-gray-700 hover:border-gray-300 hover:bg-gray-50">
                        Open
                    </a>

                    <form action="{{ route('admin.registrations.approve', $user) }}" method="POST" onsubmit="return confirm('Approve this registration?');">
                        @csrf
                        <button class="inline-flex items-center rounded-md bg-green-600 px-3 py-2 text-sm font-medium text-white hover:bg-green-700">
                            Approve
                        </button>
                    </form>

                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $users->links() }}
    </div>
</div>
@endsection