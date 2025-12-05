<div class="bg-white rounded-lg shadow p-6 border border-gray-200">
    <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $title }}</h3>
    <p class="text-sm text-gray-600 mb-4">{{ $text }}</p>
    <a href="{{ route($route) }}" 
       class="inline-block px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded hover:bg-orange-600 transition">
        {{ $button }}
    </a>
</div>



