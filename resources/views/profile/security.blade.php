<x-profile.layout>
    <form method="POST" action="{{ route('profile.security.update') }}" class="space-y-4 max-w-md">
        @csrf

        @if(session('success'))
            <div class="text-green-600">{{ session('success') }}</div>
        @endif

        <x-input.label for="current_password" value="Current Password" />
        <x-input.password name="current_password" required />

        <x-input.label for="password" value="New Password" />
        <x-input.password name="password" required />

        <x-input.label for="password_confirmation" value="Confirm New Password" />
        <x-input.password name="password_confirmation" required />

        <x-button.primary>Update Password</x-button.primary>
    </form>
</x-profile.layout>
