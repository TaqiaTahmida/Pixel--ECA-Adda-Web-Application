@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10">
    <h1 class="text-3xl font-bold text-orange-600 mb-8">Latest Blogs</h1>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($blogs as $blog)
        <a href="{{ route('blogs.show', $blog) }}" class="bg-white rounded-lg shadow hover:shadow-md transition p-4">
            @if($blog->thumbnail)
                <img src="{{ asset('storage/' . $blog->thumbnail) }}" class="rounded mb-4 w-full h-48 object-cover">
            @endif
            <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $blog->title }}</h2>
            <p class="text-sm text-gray-600">{{ $blog->excerpt }}</p>
        </a>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $blogs->links() }}
    </div>
</div>
@endsection
