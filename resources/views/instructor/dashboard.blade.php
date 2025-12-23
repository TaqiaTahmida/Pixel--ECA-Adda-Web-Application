@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-16 px-6">
    <div class="bg-white shadow rounded-2xl p-10 text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Instructor Dashboard</h1>
        <p class="text-gray-600">You are logged in as instructor. Features will be added here soon.</p>

        <form method="POST" action="{{ route('instructor.logout') }}" class="mt-8 inline-block">
            @csrf
            <button type="submit"
                    class="px-5 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition">
                Logout
            </button>
        </form>
    </div>
</div>
@endsection
