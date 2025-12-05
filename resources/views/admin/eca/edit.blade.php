@extends('layouts.app')

@section('content')

<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-6">

        <h1 class="text-3xl font-bold text-orange-600 mb-6">Edit ECA</h1>

        <form action="{{ route('eca.update', $eca->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid gap-6">

                <div>
                    <label class="font-semibold">Title</label>
                    <input type="text" name="title" value="{{ $eca->title }}" class="w-full border p-3 rounded-lg">
                </div>

                <div>
                    <label class="font-semibold">Category</label>
                    <input type="text" name="category" value="{{ $eca->category }}" class="w-full border p-3 rounded-lg">
                </div>

                <div>
                    <label class="font-semibold">Level</label>
                    <input type="text" name="level" value="{{ $eca->level }}" class="w-full border p-3 rounded-lg">
                </div>

                <div>
                    <label class="font-semibold">Short Description</label>
                    <textarea name="short_description" class="w-full border p-3 rounded-lg">{{ $eca->short_description }}</textarea>
                </div>

                <div>
                    <label class="font-semibold">Full Description</label>
                    <textarea name="full_description" class="w-full border p-3 rounded-lg">{{ $eca->full_description }}</textarea>
                </div>

                <div>
                    <label class="font-semibold">Instructor</label>
                    <input type="text" name="instructor" value="{{ $eca->instructor }}" class="w-full border p-3 rounded-lg">
                </div>

                <div>
                    <label class="font-semibold">Thumbnail</label>
                    <input type="file" name="thumbnail" class="w-full border p-3 rounded-lg">

                    @if($eca->thumbnail)
                        <img src="{{ $eca->thumbnail }}" class="h-24 mt-3 rounded">
                    @endif
                </div>

            </div>

            <button class="mt-6 px-6 py-3 bg-orange-600 text-white rounded-xl hover:bg-orange-700">
                Update ECA
            </button>

        </form>
    </div>
</section>

@endsection
