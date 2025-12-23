<?php

// app/Http/Controllers/ReactionController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reaction;
use Illuminate\Support\Facades\Auth;

class ReactionController extends Controller
{
    // Store reaction
    public function store(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|string|max:20',
        ]);

        Reaction::create([
            'achievement_id' => $id,
            'user_id' => Auth::id(),
            'type' => $request->type,
        ]);

        return redirect()->back();
    }
}
