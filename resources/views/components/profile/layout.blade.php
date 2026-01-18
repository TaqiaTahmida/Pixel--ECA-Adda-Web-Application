<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Profile Management</h2>
    </x-slot>

    <div class="p-6">
        <div class="mb-4 border-b">
            <nav class="flex space-x-4 text-sm font-medium text-gray-600">
                <a href="{{ route('profile.info') }}" class="pb-2 border-b-2 {{ request()->routeIs('profile.info') ? 'border-orange-500 text-orange-600' : 'border-transparent' }}">Info</a>
                <a href="{{ route('profile.ecas') }}" class="pb-2 border-b-2 {{ request()->routeIs('profile.ecas') ? 'border-orange-500 text-orange-600' : 'border-transparent' }}">My ECAs</a>
                <a href="{{ route('profile.subscription') }}" class="pb-2 border-b-2 {{ request()->routeIs('profile.subscription') ? 'border-orange-500 text-orange-600' : 'border-transparent' }}">Subscription</a>
                <a href="{{ route('profile.security') }}" class="pb-2 border-b-2 {{ request()->routeIs('profile.security') ? 'border-orange-500 text-orange-600' : 'border-transparent' }}">Security</a>
            </nav>
        </div>

        {{ $slot }}
    </div>
</x-app-layout>
