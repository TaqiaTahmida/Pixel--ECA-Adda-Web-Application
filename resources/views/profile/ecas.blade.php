<x-profile.layout>
    <h3 class="text-lg font-semibold mb-4">Enrolled ECAs</h3>

    @if($ecas->isEmpty())
        <p class="text-gray-600">You haven’t enrolled in any ECAs yet.</p>
    @else
        <ul class="list-disc pl-5 text-gray-800">
            @foreach($ecas as $eca)
                <li>{{ $eca->title }}</li>
            @endforeach
        </ul>
    @endif
</x-profile.layout>
