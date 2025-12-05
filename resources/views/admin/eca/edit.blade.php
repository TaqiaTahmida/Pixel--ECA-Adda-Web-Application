@extends('layouts.app')

@section('content')
<<<<<<< HEAD

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

=======
<div class="container">
    <h1 class="mb-4">Edit ECA</h1>

    <form action="{{ route('eca.update', $eca->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div class="mb-3">
            <label class="form-label">Title *</label>
            <input type="text" name="title" class="form-control" value="{{ $eca->title }}" required>
        </div>

        {{-- Category --}}
        <div class="mb-3">
            <label class="form-label">Category *</label>
            <input type="text" name="category" class="form-control" value="{{ $eca->category }}" required>
        </div>

        {{-- Level --}}
        <div class="mb-3">
            <label class="form-label">Level</label>
            <input type="text" name="level" class="form-control" value="{{ $eca->level }}">
        </div>

        {{-- Instructor --}}
        <div class="mb-3">
            <label class="form-label">Instructor</label>
            <input type="text" name="instructor" class="form-control" value="{{ $eca->instructor }}">
        </div>

        {{-- Short Description --}}
        <div class="mb-3">
            <label class="form-label">Short Description *</label>
            <textarea name="short_description" class="form-control" required>{{ $eca->short_description }}</textarea>
        </div>

        {{-- Full Description --}}
        <div class="mb-3">
            <label class="form-label">Full Description *</label>
            <textarea name="full_description" class="form-control" rows="6" required>{{ $eca->full_description }}</textarea>
        </div>

        {{-- Existing Thumbnail --}}
        @if($eca->thumbnail)
            <div class="mb-3">
                <label class="form-label">Current Thumbnail</label><br>
                <img src="{{ $eca->thumbnail }}" width="120">
            </div>
        @endif

        {{-- Upload New Thumbnail --}}
        <div class="mb-3">
            <label class="form-label">Replace Thumbnail</label>
            <input type="file" name="thumbnail" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update ECA</button>
    </form>
</div>
>>>>>>> aaf161fdcc795741c345b28f03effb13b5d016b2
@endsection
