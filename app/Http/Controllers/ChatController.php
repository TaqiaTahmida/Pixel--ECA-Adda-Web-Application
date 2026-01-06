<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Embedded in the hub
    public function index()
    {
        return redirect()->route('dashboard.hub');
    }

    // Store new message
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        ChatMessage::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        $tab = $request->query('tab', 'chat');

        return redirect()->route('dashboard.hub', ['tab' => $tab]);
    }
}
