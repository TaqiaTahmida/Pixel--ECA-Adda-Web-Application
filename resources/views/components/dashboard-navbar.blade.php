<nav class="w-full shadow-sm bg-white fixed top-0 left-0 z-50">
    <div class="max-w-7xl mx-auto flex items-center justify-between py-4 px-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard.index') }}" class="flex items-center gap-3">
                <img src="/landing/images/logo.png" class="w-9" alt="ECA Adda logo">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-gray-400">User Dashboard</p>
                    <p class="text-lg font-semibold text-orange-600">ECA Adda</p>
                </div>
            </a>
        </div>

        <div class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-600">
            <a href="{{ route('dashboard.index') }}"
               class="{{ request()->routeIs('dashboard.index') ? 'text-orange-600' : 'hover:text-orange-500' }} transition">
                Dashboard
            </a>
            <a href="{{ route('dashboard.profile') }}"
               class="{{ request()->routeIs('dashboard.profile', 'dashboard.subscription', 'dashboard.security') ? 'text-orange-600' : 'hover:text-orange-500' }} transition">
                Profile
            </a>
            <a href="{{ route('dashboard.ecas') }}"
               class="{{ request()->routeIs('dashboard.ecas') ? 'text-orange-600' : 'hover:text-orange-500' }} transition">
                ECAs
            </a>
            <a href="{{ route('calendar.my-events') }}"
               class="{{ request()->routeIs('calendar.*') ? 'text-orange-600' : 'hover:text-orange-500' }} transition">
                Calendar
            </a>
            <a href="{{ route('dashboard.query.create') }}"
               class="{{ request()->routeIs('dashboard.query.*') ? 'text-orange-600' : 'hover:text-orange-500' }} transition">
                Queries
            </a>
            <a href="{{ route('dashboard.aidash') }}"
               class="{{ request()->routeIs('dashboard.aidash') ? 'text-orange-600' : 'hover:text-orange-500' }} transition">
                AI Advisor
            </a>
            <a href="{{ route('blogs.index') }}"
               class="{{ request()->routeIs('blogs.*') ? 'text-orange-600' : 'hover:text-orange-500' }} transition">
                Blogs
            </a>
            <a href="{{ route('dashboard.hub') }}"
               class="{{ request()->routeIs('dashboard.hub') ? 'text-orange-600' : 'hover:text-orange-500' }} transition">
                Hub
            </a>
            @if(optional(Auth::user())->package_type === 'tier2')
                <a href="{{ route('dashboard.session') }}"
                   class="{{ request()->routeIs('dashboard.session', 'dashboard.session.instructor') ? 'text-orange-600' : 'hover:text-orange-500' }} transition">
                    Sessions
                </a>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard.messages') }}"
               class="relative inline-flex h-9 w-9 items-center justify-center rounded-full border border-gray-200 text-gray-600 hover:bg-gray-50"
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
            <span class="hidden sm:inline text-sm text-gray-600">
                {{ optional(Auth::user())->name ?? 'User' }}
            </span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                        class="px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-md hover:bg-gray-800 transition">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>

<div class="pt-20"></div>
