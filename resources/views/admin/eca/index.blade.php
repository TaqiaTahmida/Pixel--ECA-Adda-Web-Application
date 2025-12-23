@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-gray-400">ECAs</p>
            <h2 class="text-2xl font-semibold text-gray-900">Manage ECAs</h2>
        </div>
        <a href="{{ route('admin.ecas.create') }}"
           class="inline-flex items-center rounded-md bg-orange-500 px-4 py-2 text-sm font-medium text-white hover:bg-orange-600 transition">
            Add New ECA
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if($ecas->count() == 0)
        <p class="text-gray-600">No ECAs available.</p>
    @else
        <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($ecas as $eca)
                <div class="flex flex-col overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm transition hover:shadow-md">
                    <img src="{{ $eca->thumbnail ?? '/default-eca.png' }}"
                         class="h-40 w-full object-cover"
                         alt="{{ $eca->title }} thumbnail">

                    <div class="flex flex-1 flex-col justify-between p-4">
                        <div>
                            <h3 class="text-base font-semibold text-gray-900">{{ $eca->title }}</h3>
                            <p class="mt-1 text-xs font-medium uppercase tracking-wide text-orange-600">
                                {{ ucfirst($eca->category) ?? 'General' }}
                            </p>
                            <p class="mt-2 text-sm text-gray-600">
                                Level: <span class="font-semibold">{{ $eca->level ?? 'Beginner' }}</span>
                            </p>
                            <p class="mt-1 text-sm text-gray-500">
                                Instructor: {{ $eca->instructor }}
                            </p>
                        </div>

                        <div class="mt-3 flex gap-2">
                            <a href="{{ route('admin.ecas.edit', $eca->id) }}"
                               class="flex-1 inline-flex items-center justify-center rounded-md border border-gray-200 px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50">
                                Edit
                            </a>

                            <form action="{{ route('admin.ecas.destroy', $eca->id) }}" method="POST" class="flex-1"
                                  onsubmit="return confirm('Are you sure you want to delete this ECA?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-full inline-flex items-center justify-center rounded-md bg-red-600 px-3 py-2 text-xs font-semibold text-white hover:bg-red-700">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
