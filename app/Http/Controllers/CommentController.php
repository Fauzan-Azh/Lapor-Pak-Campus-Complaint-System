<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     */
    public function store(Request $request, Ticket $ticket)
    {
        // Pastikan user bisa mengakses tiket ini
        if (!Auth::user()->is_admin && $ticket->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        Comment::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $validated['message'],
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
    }
}
