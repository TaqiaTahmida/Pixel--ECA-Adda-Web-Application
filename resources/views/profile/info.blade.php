<x-profile.layout>
    <form method="POST" action="{{ route('profile.info.update') }}" class="space-y-4 max-w-md">
        @csrf

        @if(session('success'))
            <div class="text-green-600">{{ session('success') }}</div>
        @endif

        @error('ecas')
            <div class="text-red-600">{{ $message }}</div>
        @enderror

        <x-input.label for="name" value="Name" />
        <x-input.text name="name" :value="$user->name" required />

        <x-input.label for="email" value="Email" />
        <x-input.text name="email" :value="$user->email" disabled />

        <x-input.label for="phone" value="Phone" />
        <x-input.text name="phone" :value="$user->phone" required />

        <x-button.primary>Update Info</x-button.primary>
    </form>
</x-profile.layout>
