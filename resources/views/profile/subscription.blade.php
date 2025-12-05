<x-profile.layout>
    <p><strong>Tier:</strong> {{ $user->subscription }}</p>
    <p><strong>ECAs Enrolled:</strong> {{ $user->ecas()->count() }}</p>

    @if($user->ecas()->count() < 3)
        <div class="text-red-600 mt-2">You must enroll in at least 3 ECAs to maintain your subscription.</div>
    @endif
</x-profile.layout>
