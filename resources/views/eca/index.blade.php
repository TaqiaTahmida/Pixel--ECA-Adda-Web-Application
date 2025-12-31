@extends(auth()->check() ? 'layouts.dashboard' : 'layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <p class="text-sm uppercase tracking-[0.3em] text-gray-400">Explore</p>
            <h1 class="text-2xl font-semibold text-gray-900">Explore ECAs</h1>
            <p class="text-gray-600">Browse and enroll in extracurricular opportunities.</p>
        </div>
        @auth
            <div class="flex items-center gap-3">
                <a href="{{ route('eca.my') }}"
                   class="inline-flex items-center px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded-md hover:bg-orange-600 transition">
                    My ECAs
                </a>
                <a href="{{ route('dashboard.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-md shadow-sm hover:border-gray-300 transition">
                    Back to Dashboard
                </a>
            </div>
        @endauth
    </div>

    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
        <form method="GET" action="{{ route('eca.index') }}"
              class="mb-6 flex flex-col lg:flex-row gap-4 lg:items-end">
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-600 mb-2">Search</label>
                <input
                    id="search"
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by title, category or instructor"
                    class="w-full px-4 py-2 border border-gray-200 rounded-md focus:ring-2 focus:ring-orange-400 focus:border-orange-400"
                >
            </div>

            <div class="w-full lg:w-52">
                <label for="sort" class="block text-sm font-medium text-gray-600 mb-2">Sort</label>
                <select
                    id="sort"
                    name="sort"
                    class="w-full px-4 py-2 border border-gray-200 rounded-md focus:ring-2 focus:ring-orange-400 focus:border-orange-400"
                >
                    <option value="">Sort by</option>
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                    <option value="az" {{ request('sort') == 'az' ? 'selected' : '' }}>A-Z</option>
                    <option value="level" {{ request('sort') == 'level' ? 'selected' : '' }}>Level</option>
                </select>
            </div>

            <div class="lg:self-end">
                <button
                    type="submit"
                    class="w-full lg:w-auto px-6 py-2 bg-orange-500 text-white rounded-md font-medium hover:bg-orange-600 transition"
                >
                    Apply
                </button>
            </div>
        </form>

        @if($ecas->count() == 0)
            <p class="text-gray-600">No ECAs available right now.</p>
        @else
            <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach ($ecas as $eca)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200 hover:shadow-md transition flex flex-col">
                        <img src="{{ $eca->thumbnail ?? '/default-eca.png' }}"
                             class="w-full h-48 object-cover"
                             alt="{{ $eca->title }} thumbnail">

                        <div class="p-5 flex-1 flex flex-col">
                            <h2 class="text-lg font-semibold text-gray-900">
                                {{ $eca->title }}
                            </h2>

                            <p class="text-sm text-orange-600 font-medium mt-1">
                                {{ ucfirst($eca->category) ?? 'General' }}
                            </p>

                            <p class="text-gray-600 text-sm mt-3">
                                {{ Str::limit($eca->short_description, 80) }}
                            </p>

                            <div class="mt-4">
                                <span class="px-3 py-1 bg-orange-100 text-orange-600 rounded-full text-sm">
                                    {{ $eca->level ?? 'Beginner' }}
                                </span>
                            </div>

                            <div class="mt-6 flex gap-3">
                                <a href="{{ route('eca.show', $eca->id) }}"
                                   class="flex-1 text-center px-4 py-2 border border-orange-500 text-orange-600 rounded-md font-medium hover:bg-orange-500 hover:text-white transition">
                                    View Details
                                </a>

                                @auth
                                    <a href="{{ route('eca.show', $eca->id) }}"
                                       class="flex-1 text-center px-4 py-2 bg-orange-500 text-white rounded-md font-medium hover:bg-orange-600 transition">
                                        Enroll
                                    </a>
                                @else
                                    <a href="{{ route('login') }}"
                                       class="flex-1 text-center px-4 py-2 bg-orange-500 text-white rounded-md font-medium hover:bg-orange-600 transition">
                                        Login
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
