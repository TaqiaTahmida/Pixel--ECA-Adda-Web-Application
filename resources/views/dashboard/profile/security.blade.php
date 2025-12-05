@extends('dashboard.profile')

@section('profile-section')
<form action="{{ route('dashboard.password.update') }}" method="POST" class="space-y-6 max-w-xl">
    @csrf
    @method('PUT')

    <div>
        <label class="block text-sm font-medium text-gray-700">Current Password</label>
        <input type="password" name="current_password"
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
        @error('current_password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">New Password</label>
        <input type="password" name="new_password"
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
        @error('new_password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Confirm New Password</label>
        <input type="password" name="new_password_confirmation"
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
    </div>

    <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600 transition">
        Update Password
    </button>
</form>
@endsection
