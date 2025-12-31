@extends(auth()->check() ? 'layouts.dashboard' : 'layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <p class="text-sm uppercase tracking-[0.3em] text-gray-400">Blogs</p>
            <h1 class="text-2xl font-semibold text-gray-900">Latest Blogs</h1>
            <p class="text-gray-600">Read stories, updates, and tips from the community.</p>
        </div>
        @auth
            <a href="{{ route('dashboard.index') }}"
               class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-md shadow-sm hover:border-gray-300 transition">
                Back to Dashboard
            </a>
        @endauth
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($blogs as $blog)
        <a href="{{ route('blogs.show', $blog) }}" class="bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition p-4">
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
