<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AdminMessage;
use Illuminate\Support\Facades\Auth;

class AdminMessageController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $messages = AdminMessage::where('user_id', $userId)
            ->latest()
            ->paginate(15);

        return view('dashboard.messages.index', compact('messages'));
    }

    public function markRead(AdminMessage $message)
    {
        $this->authorizeMessage($message);

        if ($message->read_at === null) {
            $message->read_at = now();
            $message->save();
        }

        return redirect()
            ->route('dashboard.messages')
            ->with('status', 'Message marked as read.');
    }

    public function destroy(AdminMessage $message)
    {
        $this->authorizeMessage($message);

        $message->delete();

        return redirect()
            ->route('dashboard.messages')
            ->with('status', 'Message deleted.');
    }

    private function authorizeMessage(AdminMessage $message): void
    {
        if ($message->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
