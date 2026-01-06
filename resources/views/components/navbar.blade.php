<nav class="w-full shadow-sm bg-white fixed top-0 left-0 z-50">
    <div class="max-w-7xl mx-auto flex items-center justify-between py-4 px-6">

        <!-- Logo (always goes to landing page) -->
        <div class="flex items-center gap-2">
            <a href="{{ route('landing') }}">
                <img src="/landing/images/logo.png" class="w-8" alt="logo">
            </a>
            <span class="font-semibold text-lg text-orange-600">ECA Adda</span>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex gap-4 items-center">

            {{-- ================= USER LOGGED IN ================= --}}
            @auth
                {{-- Show dashboard ONLY on landing page --}}
                @if(request()->routeIs('landing'))
                    <a href="{{ route('dashboard.index') }}"
                       class="px-5 py-2 border border-orange-500 text-orange-600 rounded-lg font-semibold
                              hover:bg-orange-500 hover:text-white transition">
                        Dashboard
                    </a>
                @endif

                <a href="{{ route('dashboard.messages') }}"
                   class="relative inline-flex h-9 w-9 items-center justify-center rounded-full border border-orange-200 text-orange-600 hover:bg-orange-50 transition"
                   title="Messages">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3.75h6m-9 5.25 3.75-3.75h8.25a2.25 2.25 0 0 0 2.25-2.25V6a2.25 2.25 0 0 0-2.25-2.25H6A2.25 2.25 0 0 0 3.75 6v10.5a.75.75 0 0 0 1.28.53z" />
                    </svg>
                    @if(($unreadAdminMessages ?? 0) > 0)
                        <span class="absolute -top-1 -right-1 min-w-[16px] rounded-full bg-red-500 px-1 text-[10px] font-semibold text-white">
                            {{ $unreadAdminMessages }}
                        </span>
                    @endif
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button
                        class="px-5 py-2 bg-orange-500 text-white rounded-lg font-semibold
                               hover:bg-orange-600 transition">
                        Logout
                    </button>
                </form>
            @endauth


            {{-- ================= ADMIN LOGGED IN ================= --}}
            @auth('admin')
                {{-- Show dashboard ONLY on landing page --}}
                @if(request()->routeIs('landing'))
                    <a href="{{ route('admin.dashboard') }}"
                       class="px-5 py-2 border border-gray-800 text-gray-800 rounded-lg font-semibold
                              hover:bg-gray-800 hover:text-white transition">
                        Admin Dashboard
                    </a>
                @endif

                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button
                        class="px-5 py-2 bg-orange-500 text-white rounded-lg font-semibold
                               hover:bg-orange-600 transition">
                        Admin Logout
                    </button>
                </form>
            @endauth


            {{-- ================= NO ONE LOGGED IN ================= --}}
            @guest
                <a href="{{ route('login') }}"
                   class="px-5 py-2 border border-orange-500 text-orange-600 rounded-lg font-semibold
                          hover:bg-orange-500 hover:text-white transition">
                    Login
                </a>
                <a href="{{ route('register.step1') }}"
                   class="px-5 py-2 bg-orange-500 text-white rounded-lg font-semibold
                          hover:bg-orange-600 transition">
                    Register
                </a>
                <a href="{{ route('blogs.index') }}"
                   class="px-5 py-2 border border-orange-500 text-orange-600 rounded-lg font-semibold
                          hover:bg-orange-500 hover:text-white transition">
                    Blog
                </a>
            @endguest

        </div>
    </div>
</nav>

<div class="pt-20"></div>
