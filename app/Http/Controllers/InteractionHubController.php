<?php

// app/Http/Controllers/InteractionHubController.php
namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\Achievement;

class InteractionHubController extends Controller
{
    public function index()
    {
        $messages = ChatMessage::with('user')->latest()->take(50)->get();
        $achievements = Achievement::with(['user', 'reactions.user'])->latest()->get();

        return view('dashboard.hub', compact('messages', 'achievements'));
    }
}

