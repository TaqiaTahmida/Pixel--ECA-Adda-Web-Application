<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderByDesc('created_at')->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function message(User $user)
    {
        return view('admin.users.message', compact('user'));
    }

    public function sendMessage(Request $request, User $user)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        AdminMessage::create([
            'admin_id' => Auth::guard('admin')->id(),
            'user_id' => $user->id,
            'message' => $validated['message'],
        ]);

        return redirect()
            ->route('admin.users.message', $user)
            ->with('success', 'Message sent successfully.');
    }
}
?>
