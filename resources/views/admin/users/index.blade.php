@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Users</p>
            <h2 class="text-2xl font-semibold text-gray-900">All Users</h2>
        </div>
        <span class="text-sm text-gray-500">{{ $users->total() }} total</span>
    </div>

    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Phone</th>
                    <th class="px-4 py-3">Institution</th>
                    <th class="px-4 py-3">Package</th>
                    <th class="px-4 py-3">Registration</th>
                    <th class="px-4 py-3">Payment</th>
                    <th class="px-4 py-3">Joined</th>
                    <th class="px-4 py-3 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium text-gray-900">{{ $user->name }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ $user->email }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ $user->phone ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ $user->institution ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-700 capitalize">{{ $user->package_type ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ $user->registration_status ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ $user->payment_status ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ optional($user->created_at)->format('d M, Y') }}</td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.users.message', $user) }}"
                               class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-gray-200 text-gray-600 hover:bg-gray-50"
                               title="Message">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3.75h6m-9 5.25 3.75-3.75h8.25a2.25 2.25 0 0 0 2.25-2.25V6a2.25 2.25 0 0 0-2.25-2.25H6A2.25 2.25 0 0 0 3.75 6v10.5a.75.75 0 0 0 1.28.53z" />
                                </svg>
                            </a>
                            <a href="{{ route('admin.users.show', $user) }}"
                               class="inline-flex items-center rounded-md border border-gray-200 px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50">
                                View
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-4 py-6 text-center text-sm text-gray-500">No users found.</td>
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
