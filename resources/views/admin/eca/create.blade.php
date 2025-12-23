@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto px-6">
    <div class="mb-6">
        <p class="text-xs uppercase tracking-[0.3em] text-gray-400">ECAs</p>
        <h2 class="text-2xl font-semibold text-gray-900">Add New ECA</h2>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.ecas.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5 rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
        @csrf

        {{-- Title --}}
        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Title *</label>
            <input type="text" name="title" required
                   class="w-full rounded-md border border-gray-200 px-3 py-2 text-sm focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-100">
        </div>

        {{-- Category --}}
        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Category *</label>
            <input type="text" name="category" required
                   class="w-full rounded-md border border-gray-200 px-3 py-2 text-sm focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-100">
        </div>

        {{-- Level --}}
        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Level</label>
            <input type="text" name="level"
                   class="w-full rounded-md border border-gray-200 px-3 py-2 text-sm focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-100">
        </div>

        {{-- Instructor --}}
        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Instructor</label>
            <input type="text" name="instructor"
                   class="w-full rounded-md border border-gray-200 px-3 py-2 text-sm focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-100">
        </div>

        {{-- Short Description --}}
        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Short Description *</label>
            <textarea name="short_description" required
                      class="w-full rounded-md border border-gray-200 px-3 py-2 text-sm focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-100"></textarea>
        </div>

        {{-- Full Description --}}
        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Full Description *</label>
            <textarea name="full_description" rows="6" required
                      class="w-full rounded-md border border-gray-200 px-3 py-2 text-sm focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-100"></textarea>
        </div>

        {{-- Thumbnail --}}
        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Thumbnail (optional)</label>
            <input type="file" name="thumbnail"
                   class="w-full rounded-md border border-gray-200 px-3 py-2 text-sm focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-100">
        </div>

        {{-- Submit Button --}}
        <div class="pt-2">
            <button type="submit"
                    class="w-full rounded-md bg-orange-500 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-600 transition">
                Create ECA
            </button>
        </div>
    </form>
</div>
@endsection
