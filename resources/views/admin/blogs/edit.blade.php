@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto px-6">
    <div class="mb-6">
        <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Blogs</p>
        <h2 class="text-2xl font-semibold text-gray-900">Edit Blog</h2>
    </div>

    <form method="POST" action="{{ route('admin.blogs.update', $blog) }}" enctype="multipart/form-data" class="space-y-5 rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
        @csrf
        @method('PUT')

        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Title</label>
            <input type="text" name="title" value="{{ old('title', $blog->title) }}" required class="w-full rounded-md border border-gray-200 px-3 py-2 text-sm focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-100">
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Content</label>
            <textarea name="content" rows="8" required class="w-full rounded-md border border-gray-200 px-3 py-2 text-sm focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-100">{{ old('content', $blog->content) }}</textarea>
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Thumbnail (optional)</label>
            <input type="file" name="thumbnail" class="w-full rounded-md border border-gray-200 px-3 py-2 text-sm focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-100">
            @if($blog->thumbnail)
                <img src="{{ asset('storage/' . $blog->thumbnail) }}" class="mt-2 w-32 rounded" alt="Blog thumbnail">
            @endif
        </div>

        <button type="submit" class="inline-flex items-center rounded-md bg-orange-500 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-600">
            Update
        </button>
    </form>
</div>
@endsection
