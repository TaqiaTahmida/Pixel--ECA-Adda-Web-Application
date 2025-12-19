@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Queries</p>
            <h2 class="text-2xl font-semibold text-gray-900">User Queries</h2>
        </div>
        <span class="text-sm text-gray-500">{{ $queries->total() }} total</span>
    </div>

    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-4 py-3">From</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Message</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($queries as $q)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium text-gray-900">{{ $q->name ?? ($q->user->name ?? 'User') }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $q->email }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ Str::limit($q->message, 80) }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium {{ $q->status === 'open' ? 'bg-orange-50 text-orange-700' : 'bg-green-50 text-green-700' }}">
                            {{ $q->status }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('admin.queries.show', $q) }}" class="inline-flex items-center rounded-md border border-gray-200 px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50">
                            Open
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="border-t border-gray-100 px-4 py-3">{{ $queries->links() }}</div>
    </div>
</div>
@endsection