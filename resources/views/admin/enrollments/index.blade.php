@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Enrollments</p>
            <h2 class="text-2xl font-semibold text-gray-900">ECA Enrollments</h2>
        </div>
        <span class="text-sm text-gray-500">{{ $enrollments->total() }} total</span>
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
                    <th class="px-4 py-3">Student</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">ECA</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($enrollments as $en)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium text-gray-900">{{ $en->user->name }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ $en->user->email }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ $en->eca->title }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium {{ $en->status === 'done' ? 'bg-green-50 text-green-700' : 'bg-orange-50 text-orange-700' }}">
                            {{ $en->status }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        @if($en->status !== 'done')
                        <form action="{{ route('admin.enrollments.done', $en) }}" method="POST" onsubmit="return confirm('Mark as done (moved to enrolled)?');">
                            @csrf
                            <button class="inline-flex items-center rounded-md bg-green-600 px-3 py-2 text-xs font-semibold text-white hover:bg-green-700">Done</button>
                        </form>
                        @else
                            <span class="text-sm text-gray-500">Completed</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="border-t border-gray-100 px-4 py-3">{{ $enrollments->links() }}</div>
    </div>
</div>
@endsection
