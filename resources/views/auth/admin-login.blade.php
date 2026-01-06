@extends('layouts.app')

@section('content')
<div class="min-h-[60vh] flex items-center px-6">
    <div class="w-full max-w-lg mx-auto py-16">
        <div class="text-center mb-8">
            <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Admin Portal</p>
            <h2 class="text-3xl font-semibold text-gray-900 mt-2">Admin Login</h2>
            <p class="text-sm text-gray-500 mt-2">Use your admin email to receive an OTP.</p>
        </div>

        @if ($errors->any())
            <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}"
              class="bg-white shadow-lg rounded-2xl p-8 border border-gray-100 space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Admin Email</label>
                <input id="email" type="email" name="email"
                       value="{{ old('email') }}"
                       class="mt-2 w-full rounded-md border-gray-200 px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-orange-500"
                       required>
                @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" name="password" type="password" required
                       class="mt-2 block w-full rounded-md border-gray-200 px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-orange-500">
                @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <button class="w-full bg-orange-500 text-white py-2.5 rounded-lg font-semibold
                           hover:bg-orange-600 transition duration-200">
                Send OTP
            </button>
        </form>
    </div>
</div>
@endsection
