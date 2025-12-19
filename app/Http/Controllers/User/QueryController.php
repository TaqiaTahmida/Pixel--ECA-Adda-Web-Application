<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserQuery;
use Illuminate\Http\Request;

class QueryController extends Controller
{
    /**
     * Show the query/complaint form.
     */
    public function create()
    {
        return view('dashboard.query.create');
    }

    /**
     * Store a new query/complaint from the student.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $user = $request->user();

        UserQuery::create([
            'user_id' => $user->id,
            'name' => $validated['name'] ?? $user->name,
            'email' => $validated['email'] ?? $user->email,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => 'open',
        ]);

        return redirect()
            ->route('dashboard.query.create')
            ->with('success', 'Your message has been sent!');
    }
}
