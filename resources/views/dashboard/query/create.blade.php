@extends('layouts.dashboard')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-10">
    <div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-orange-600">Send a Query or Complaint</h1>
    <a href="{{ route('dashboard.index') }}"
       class="inline-block px-4 py-2 bg-gray-200 text-gray-800 text-sm font-medium rounded hover:bg-gray-300 transition">
        Back to Dashboard
    </a>
</div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('dashboard.query.store') }}" method="POST" class="space-y-6 bg-white p-6 rounded-xl shadow border">
        @csrf

        <div>
            <label class="block text-gray-700 font-medium mb-2">Subject *</label>
            <input type="text" name="subject" required
                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none">
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-2">Message *</label>
            <textarea name="message" rows="6" required
                      class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none"></textarea>
        </div>

        <div>
            <button type="submit"
                    class="w-full bg-orange-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-orange-600 transition">
                Send Message
            </button>
        </div>
    </form>
</div>
@endsection
