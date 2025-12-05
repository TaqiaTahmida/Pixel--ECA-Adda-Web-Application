<nav class="w-full bg-white shadow fixed top-0 left-0 z-50">
    <div class="max-w-7xl mx-auto flex items-center justify-between py-4 px-6">
        <div class="flex items-center gap-2">
            <img src="/landing/images/logo.png" class="w-8" alt="logo">
            <span class="font-semibold text-lg text-orange-600">ECA Adda</span>
        </div>

        <div class="flex items-center gap-4">
            <span class="text-gray-700 font-medium">Welcome, {{ Auth::user()->name }}!</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" 
                        class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>
