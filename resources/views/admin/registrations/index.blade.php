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

    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Package</th>
                    <th class="px-4 py-3">Registered</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium text-gray-900">{{ $user->name }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ $user->email }}</td>
                    <td class="px-4 py-3 text-gray-700">
                        <span class="inline-flex items-center rounded-full bg-orange-50 px-3 py-1 text-xs font-medium text-orange-600 capitalize">
                            {{ $user->package_type ?? 'tier2' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-600">{{ optional($user->created_at)->format('d M, Y H:i') }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ $user->registration_status }}</td>
                    <td class="px-4 py-3 text-right">
                        <div class="inline-flex flex-wrap items-center gap-2">
                            <a href="{{ route('admin.registrations.show', $user) }}" class="inline-flex items-center rounded-md border border-gray-200 px-3 py-2 text-xs font-semibold text-gray-700 hover:border-gray-300 hover:bg-gray-50">
                                Open
                            </a>

                            <form action="{{ route('admin.registrations.approve', $user) }}" method="POST" onsubmit="return confirm('Approve this registration?');">
                                @csrf
                                <button class="inline-flex items-center rounded-md bg-green-600 px-3 py-2 text-xs font-semibold text-white hover:bg-green-700">
                                    Approve
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-sm text-gray-500">No pending registrations.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="border-t border-gray-100 px-4 py-3">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
