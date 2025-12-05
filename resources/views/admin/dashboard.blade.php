@extends('layouts.app')

@section('content')

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6 text-center">

        <h1 class="text-4xl font-bold text-orange-600 mb-4">
            Admin Dashboard
        </h1>

        <p class="text-gray-600 mb-10">
            Manage ECAs, Students, and Platform Content
        </p>

        <a href="{{ route('eca.index') }}" 
           class="px-6 py-3 bg-orange-600 text-white rounded-xl hover:bg-orange-700 transition">
           Manage ECAs
        </a>

    </div>
</section>

@endsection
