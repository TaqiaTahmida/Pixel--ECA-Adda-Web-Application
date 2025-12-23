@extends('dashboard.profile')

@section('profile-section')
<div class="max-w-xl mx-auto space-y-4">
    <h3 class="text-lg font-semibold text-gray-800">Current Subscription</h3>

    <div class="bg-gray-50 border border-gray-200 rounded-md p-4">
        <p class="text-sm text-gray-600">Plan: 
            <span class="font-medium text-orange-600">{{ $user->package_type === 'tier2' ? 'Tier 2' : 'Tier 1' }}</span>
        </p>
        <p class="text-sm text-gray-600">Courses Included: 
            <span class="font-medium">{{ $user->package_type === 'tier2' ? '5' : '2' }}</span>
        </p>
        <span class="inline-block mt-2 px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full">Active</span>
    </div>
</div>
@endsection
