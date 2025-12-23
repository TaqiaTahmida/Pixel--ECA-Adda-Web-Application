@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto px-6">
    <div class="mb-6">
        <p class="text-xs uppercase tracking-[0.3em] text-gray-400">ECAs</p>
        <h2 class="text-2xl font-semibold text-gray-900">Edit ECA</h2>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.ecas.update', $eca->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5 rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Title *</label>
            <input type="text" name="title" value="{{ $eca->title }}" required
                   class="w-full rounded-md border border-gray-200 px-3 py-2 text-sm focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-100">
        </div>

        {{-- Category --}}
        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Category *</label>
            <input type="text" name="category" value="{{ $eca->category }}" required
                   class="w-full rounded-md border border-gray-200 px-3 py-2 text-sm focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-100">
        </div>

        {{-- Level --}}
        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Level</label>
            <input type="text" name="level" value="{{ $eca->level }}"
                   class="w-full rounded-md border border-gray-200 px-3 py-2 text-sm focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-100">
        </div>

        {{-- Instructor --}}
        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Instructor</label>
            <input type="text" name="instructor" value="{{ $eca->instructor }}"
                   class="w-full rounded-md border border-gray-200 px-3 py-2 text-sm focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-100">
        </div>

        {{-- Short Description --}}
        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Short Description *</label>
            <textarea name="short_description" required
                      class="w-full rounded-md border border-gray-200 px-3 py-2 text-sm focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-100">{{ $eca->short_description }}</textarea>
        </div>

        {{-- Full Description --}}
        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Full Description *</label>
            <textarea name="full_description" rows="6" required
                      class="w-full rounded-md border border-gray-200 px-3 py-2 text-sm focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-100">{{ $eca->full_description }}</textarea>
        </div>

        {{-- Existing Thumbnail --}}
        @if($eca->thumbnail)
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Current Thumbnail</label>
                <img src="{{ $eca->thumbnail }}" class="w-32 rounded-lg border" alt="Current thumbnail">
            </div>
        @endif

        {{-- Upload New Thumbnail --}}
        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Replace Thumbnail</label>
            <input type="file" name="thumbnail"
                   class="w-full rounded-md border border-gray-200 px-3 py-2 text-sm focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-100">
        </div>

        {{-- Submit Button --}}
        <div class="pt-2">
            <button type="submit"
                    class="w-full rounded-md bg-orange-500 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-600 transition">
                Update ECA
            </button>
        </div>
    </form>
</div>
@endsection
