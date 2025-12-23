@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto px-6">
    <div class="mb-6">
        <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Users</p>
        <h2 class="text-2xl font-semibold text-gray-900">User: {{ $user->name }}</h2>
        <p class="text-sm text-gray-500">Review full profile information.</p>
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
                <dd class="mt-1 text-sm text-gray-700 capitalize">{{ $user->package_type ?? '-' }}</dd>
            </div>
            <div>
                <dt class="text-xs uppercase tracking-wide text-gray-400">Role</dt>
                <dd class="mt-1 text-sm text-gray-700">{{ $user->role ?? '-' }}</dd>
            </div>
            <div>
                <dt class="text-xs uppercase tracking-wide text-gray-400">Registration Status</dt>
                <dd class="mt-1 text-sm text-gray-700">{{ $user->registration_status ?? '-' }}</dd>
            </div>
            <div>
                <dt class="text-xs uppercase tracking-wide text-gray-400">Payment Status</dt>
                <dd class="mt-1 text-sm text-gray-700">{{ $user->payment_status ?? '-' }}</dd>
            </div>
            <div>
                <dt class="text-xs uppercase tracking-wide text-gray-400">Registered At</dt>
                <dd class="mt-1 text-sm text-gray-700">{{ optional($user->created_at)->toDayDateTimeString() }}</dd>
            </div>
            <div>
                <dt class="text-xs uppercase tracking-wide text-gray-400">Last Updated</dt>
                <dd class="mt-1 text-sm text-gray-700">{{ optional($user->updated_at)->toDayDateTimeString() }}</dd>
            </div>
            <div class="md:col-span-2">
                <dt class="text-xs uppercase tracking-wide text-gray-400">Interests</dt>
                <dd class="mt-1 text-sm text-gray-700">
                    @php($interests = $user->interests ?? [])
                    @if(is_array($interests) && count($interests))
                        <div class="flex flex-wrap gap-2">
                            @foreach($interests as $interest)
                                <span class="inline-flex items-center rounded-full bg-orange-50 px-3 py-1 text-xs font-medium text-orange-700">
                                    {{ $interest }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        -
                    @endif
                </dd>
            </div>
        </dl>

        <div class="mt-6">
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center rounded-md border border-gray-200 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                Back to list
            </a>
        </div>
    </div>
</div>
@endsection
