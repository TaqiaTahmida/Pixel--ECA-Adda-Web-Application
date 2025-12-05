@extends('layouts.app')

@section('content')

<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-6">

        <h1 class="text-3xl font-bold text-orange-600 mb-6">Add New ECA</h1>

        <form action="{{ route('eca.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid gap-6">

                <div>
                    <label class="font-semibold">Title</label>
                    <input type="text" name="title" class="w-full border p-3 rounded-lg">
                </div>

                <div>
                    <label class="font-semibold">Category</label>
                    <input type="text" name="category" class="w-full border p-3 rounded-lg">
                </div>

                <div>
                    <label class="font-semibold">Level</label>
                    <input type="text" name="level" class="w-full border p-3 rounded-lg">
                </div>

                <div>
                    <label class="font-semibold">Short Description</label>
                    <textarea name="short_description" class="w-full border p-3 rounded-lg" rows="3"></textarea>
                </div>

                <div>
                    <label class="font-semibold">Full Description</label>
                    <textarea name="full_description" class="w-full border p-3 rounded-lg" rows="6"></textarea>
                </div>

                <div>
                    <label class="font-semibold">Instructor</label>
                    <input type="text" name="instructor" class="w-full border p-3 rounded-lg">
                </div>

                <div>
                    <label class="font-semibold">Thumbnail</label>
                    <input type="file" name="thumbnail" class="w-full border p-3 rounded-lg">
                </div>

            </div>

            <button class="mt-6 px-6 py-3 bg-orange-600 text-white rounded-xl hover:bg-orange-700">
                Save ECA
            </button>

        </form>
    </div>
</section>

@endsection
