<?php

// app/Http/Controllers/AchievementController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Achievement;
use Illuminate\Support\Facades\Auth;

class AchievementController extends Controller
{
    // Embedded in the hub
    public function index()
    {
        return redirect()->route('dashboard.hub');
    }

    // Upload new achievement
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpg,png,pdf,docx|max:2048',
        ]);

        $path = $request->file('file')?->store('achievements', 'public');

        Achievement::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $path,
        ]);

        $tab = $request->query('tab', 'achievements');

        return redirect()->route('dashboard.hub', ['tab' => $tab]);
    }
}
