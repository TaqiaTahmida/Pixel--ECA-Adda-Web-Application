@extends('dashboard.profile')

@section('profile-section')
{{-- Profile Update Form --}}
<form action="{{ route('dashboard.profile.update') }}" method="POST" class="space-y-6 max-w-2xl mx-auto">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
        <input type="text" name="name" id="name"
               value="{{ old('name', $user->name) }}"
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
    </div>

    {{-- Email (read-only) --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">Email Address</label>
        <input type="email" name="email" value="{{ $user->email }}" readonly
               class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm">
    </div>

    {{-- Phone --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">Phone Number</label>
        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
        @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Education Level --}}
    <div class="mb-4">
        <label for="education_level" class="block text-sm font-medium text-gray-700">Education Level</label>
        <select name="education_level" id="education_level"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
            <option value="">Select</option>
            @foreach($educationLevels as $value => $label)
                <option value="{{ $value }}" {{ old('education_level', $user->education_level) === $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Interests --}}
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Your Interests</label>
        <div class="mt-2 grid grid-cols-2 gap-2">
            @foreach($interests as $interest)
                <label class="inline-flex items-center">
                    <input type="checkbox" name="interests[]" value="{{ $interest }}"
                           {{ in_array($interest, old('interests', $user->interests ?? [])) ? 'checked' : '' }}
                           class="form-checkbox text-orange-500">
                    <span class="ml-2 text-sm text-gray-700">{{ $interest }}</span>
                </label>
            @endforeach
        </div>
    </div>

    {{-- Submit --}}
    <div>
        <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600 transition">
            Update Profile
        </button>
    </div>
</form>
@endsection
