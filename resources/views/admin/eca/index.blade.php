@extends('layouts.app')

@section('content')

<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6">

        <h2 class="text-3xl font-bold text-orange-600 mb-6">Manage ECAs</h2>

        <a href="{{ route('eca.create') }}"
           class="px-5 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700">
           + Add New ECA
        </a>

        <div class="mt-10 bg-white shadow-xl rounded-xl border">
            <table class="w-full text-left">
                <thead class="bg-orange-50">
                    <tr>
                        <th class="p-4">Thumbnail</th>
                        <th class="p-4">Title</th>
                        <th class="p-4">Category</th>
                        <th class="p-4">Actions</th>
                    </tr>
                </thead>
                <tbody>

                @foreach ($ecas as $eca)
                    <tr class="border-b">
                        <td class="p-4">
                            <img src="{{ $eca->thumbnail }}" class="h-16 rounded">
                        </td>
                        <td class="p-4">{{ $eca->title }}</td>
                        <td class="p-4">{{ $eca->category }}</td>
                        <td class="p-4">
                            <a href="{{ route('eca.edit', $eca->id) }}" 
                               class="text-blue-600 hover:underline">Edit</a>

                            <form action="{{ route('eca.destroy', $eca->id) }}" 
                                  method="POST" class="inline-block"
                                  onsubmit="return confirm('Delete this ECA?');">
                                @csrf
                                @method('DELETE')

                                <button class="text-red-600 hover:underline ml-3">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>

    </div>
</section>

@endsection
