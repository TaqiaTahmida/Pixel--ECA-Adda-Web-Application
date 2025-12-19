@extends('layouts.dashboard')

@section('content')
<style>
    .chat-container {
        max-width: 700px;
        margin: 0 auto;
        padding: 2rem;
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }

    .chat-box {
        height: 400px;
        overflow-y: auto;
        background-color: #f3f4f6;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        font-size: 0.95rem;
    }

    .chat-box div {
        margin-bottom: 0.75rem;
    }

    .chat-box strong {
        color: #1f2937;
    }

    .chat-form .input-group {
        display: flex;
        gap: 0.5rem;
    }

    .chat-form input {
        flex: 1;
        padding: 0.75rem;
        border-radius: 6px;
        border: 1px solid #d1d5db;
    }

    .chat-form button {
        padding: 0.75rem 1.25rem;
        background-color: #2563eb;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .chat-form button:hover {
        background-color: #1d4ed8;
    }

    .back-button {
        display: inline-block;
        margin-bottom: 1rem;
        padding: 0.5rem 1rem;
        background-color: #f97316;
        color: white;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;
    }

    .back-button:hover {
        background-color: #ea580c;
    }
</style>

<div class="chat-container">
    <a href="{{ route('dashboard.index') }}" class="back-button">&lt; Back to Dashboard</a>

    <h2 class="mb-3 text-xl font-semibold text-gray-800">AI Advisor Chat</h2>
    <p class="text-sm text-gray-600 mb-4">Ask me anything about ECAs, your interests, or future plans!</p>

    <div id="chat-box" class="chat-box">
        <div class="text-gray-500">AI is ready to help you!</div>
    </div>

    <form id="chat-form" class="chat-form">
        <div class="input-group">
            <input type="text" id="user-input" placeholder="Type your question..." required>
            <button type="submit">Send</button>
        </div>
    </form>
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
    .catch(err => {
        chatBox.innerHTML += `<div class="text-red-500"><strong>Error:</strong> Could not reach AI.</div>`;
    });
});
</script>
@endsection
