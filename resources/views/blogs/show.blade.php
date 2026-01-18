@extends(auth()->check() ? 'layouts.dashboard' : 'layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between mb-6">
        <div>
            <p class="text-sm uppercase tracking-[0.3em] text-gray-400">Blog</p>
            <h1 class="text-2xl font-semibold text-gray-900">{{ $blog->title }}</h1>
        </div>
        @auth
            <a href="{{ route('dashboard.index') }}"
               class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-md shadow-sm hover:border-gray-300 transition">
                Back to Dashboard
            </a>
        @endauth
    </div>

    @if($blog->thumbnail)
        <img src="{{ asset(str_starts_with($blog->thumbnail, '/') ? $blog->thumbnail : 'storage/' . $blog->thumbnail) }}" class="rounded mb-6 w-full h-64 object-cover">
    @endif

    <div class="prose max-w-none mb-8">
        {!! nl2br(e($blog->content)) !!}
    </div>

    @auth
    <div class="mb-6">
        <form method="POST" action="{{ $liked ? route('blogs.unlike', $blog) : route('blogs.like', $blog) }}">
            @csrf
            @if($liked)
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:underline">❤️ Unlike</button>
            @else
                <button type="submit" class="text-blue-600 hover:underline">🤍 Like</button>
            @endif
            <span class="ml-2 text-sm text-gray-600">{{ $blog->likes->count() }} likes</span>
        </form>
    </div>

    <div class="mb-8">
        <h3 class="text-lg font-semibold mb-2">Leave a Comment</h3>
        <form method="POST" action="{{ route('blogs.comment', $blog) }}">
            @csrf
            <textarea name="body" rows="3" required class="w-full border rounded p-2 mb-2"></textarea>
            <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">Post</button>
        </form>
    </div>
    @endauth

    <div>
        <h3 class="text-lg font-semibold mb-4">Comments ({{ $comments->count() }})</h3>
        @forelse($comments as $comment)
            <div class="mb-4 border-b pb-2">
                <p class="text-sm text-gray-800"><strong>{{ $comment->user->name }}</strong> said:</p>
                <p class="text-gray-700">{{ $comment->body }}</p>
                <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
            </div>
        @empty
            <p class="text-gray-500">No comments yet.</p>
        @endforelse
    </div>
</div>
@endsection
