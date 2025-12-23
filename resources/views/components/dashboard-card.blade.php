<div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">{{ $title }}</h3>
    <p class="text-sm text-gray-600 mt-2">{{ $text }}</p>
    <a href="{{ route($route) }}"
       class="inline-flex items-center gap-2 mt-4 text-sm font-medium text-orange-600 hover:text-orange-700 transition">
        {{ $button }}
        <span aria-hidden="true">&rarr;</span>
    </a>
</div>


