@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-sm uppercase tracking-[0.3em] text-gray-400">Advisor</p>
            <h2 class="text-2xl font-semibold text-gray-900">AI Advisor Chat</h2>
            <p class="text-gray-600">Ask anything about ECAs, your interests, or future plans.</p>
        </div>
        <a href="{{ route('dashboard.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-md shadow-sm hover:border-gray-300 transition">
            Back to Dashboard
        </a>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
        <div id="chat-box" class="h-96 overflow-y-auto bg-gray-50 border border-gray-200 rounded-md p-4 text-sm text-gray-700 space-y-3">
            <div class="text-gray-500">AI is ready to help you!</div>
        </div>

        <form id="chat-form" class="mt-4">
            <div class="flex items-center gap-2">
                <input type="text" id="user-input" placeholder="Type your question..." required
                       class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-400 focus:outline-none">
                <button type="submit"
                        class="px-4 py-2 bg-orange-500 text-white rounded-md font-medium hover:bg-orange-600 transition">
                    Send
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('chat-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const input = document.getElementById('user-input');
    const message = input.value.trim();
    if (!message) return;

    const chatBox = document.getElementById('chat-box');
    chatBox.innerHTML += `<div><strong>You:</strong> ${message}</div>`;
    input.value = '';

    fetch("{{ route('dashboard.aidash.send') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ message })
    })
    .then(res => res.json())
    .then(data => {
        chatBox.innerHTML += `<div><strong>AI:</strong> ${data.reply}</div>`;
        chatBox.scrollTop = chatBox.scrollHeight;
    })
    .catch(() => {
        chatBox.innerHTML += '<div class="text-red-500"><strong>Error:</strong> Could not reach AI.</div>';
    });
});
</script>
@endsection
