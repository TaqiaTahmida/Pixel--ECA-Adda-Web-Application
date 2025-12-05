<nav class="w-full shadow-sm bg-white fixed top-0 left-0 z-50">
    <div class="max-w-7xl mx-auto flex items-center justify-between py-4 px-6">

        <!-- Logo -->
        <div class="flex items-center gap-2">
            <img src="/landing/images/logo.png" class="w-10" alt="logo">
        </div>

        <!-- Navigation Buttons -->
        <div class="flex gap-4">
            <!-- Register -->
            <a href="{{ route('register.step1') }}" 
               class="px-5 py-2 border-2 border-blue-600 text-blue-600 rounded-lg font-semibold hover:bg-blue-600 hover:text-white transition">
                Register
            </a>

            <!-- User Login -->
            <a href="{{ route('login') }}" 
               class="px-5 py-2 bg-orange-500 text-white rounded-lg font-semibold hover:bg-orange-600 transition">
                Login
            </a>

            <!-- Admin Login -->
            <a href="{{ route('admin.login') }}" 
               class="px-5 py-2 bg-gray-800 text-white rounded-lg font-semibold hover:bg-gray-900 transition">
                Admin Login
            </a>
        </div>
    </div>
</nav>

<div class="pt-20"></div>

