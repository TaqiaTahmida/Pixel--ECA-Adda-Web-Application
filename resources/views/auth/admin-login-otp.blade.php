@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto py-20">

    <h2 class="text-3xl font-bold text-center mb-6 text-orange-500">
        Verify Admin OTP
    </h2>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login.verify') }}"
          class="bg-white shadow-lg rounded-lg p-6 border border-gray-100">

        @csrf

        {{-- Keep admin email --}}
        <input type="hidden" name="email" value="{{ $email ?? session('admin_email') }}">

        <label class="block font-semibold mb-2">Enter OTP:</label>
        <input type="text" name="otp"
               class="w-full border rounded p-2 mb-4 focus:ring-2 focus:ring-orange-400"
               required>

        <button class="w-full bg-orange-500 text-white py-2 rounded-lg
                       hover:bg-orange-600 transition duration-200">
            Verify OTP
        </button>

    </form>

</div>
@endsection
