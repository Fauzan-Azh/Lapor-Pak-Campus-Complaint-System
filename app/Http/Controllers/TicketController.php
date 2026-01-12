<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the tickets.
     */
    public function index(Request $request)
    {
        $query = Ticket::with(['user', 'category', 'comments']);

        // Jika user bukan admin, hanya tampilkan tiket miliknya
        if (!Auth::user()->is_admin) {
            $query->where('user_id', Auth::id());
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->has('category_id') && $request->category_id !== '') {
            $query->where('category_id', $request->category_id);
        }

        $tickets = $query->latest()->paginate(10);
        $categories = Category::all();

        return view('tickets.index', compact('tickets', 'categories'));
    }

    /**
     * Show the form for creating a new ticket.
     */
    public function create()
    {
        $categories = Category::all();
        return view('tickets.create', compact('categories'));
    }

    /**
     * Store a newly created ticket in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,png|max:2048', // Max 2MB
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('ticket-images', 'public');
        }

        Ticket::create([
            'user_id' => Auth::id(),
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'location' => $validated['location'],
            'image_path' => $imagePath,
            'status' => 'pending',
        ]);

        return redirect()->route('tickets.index')->with('success', 'Tiket berhasil dibuat!');
    }

    /**
     * Display the specified ticket.
     */
    public function show(Ticket $ticket)
    {
        // User biasa hanya bisa melihat tiket miliknya
        if (!Auth::user()->is_admin && $ticket->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $ticket->load(['user', 'category', 'comments.user']);
        return view('tickets.show', compact('ticket'));
    }

    /**
     * Update the status of the ticket (admin only).
     */
    public function updateStatus(Request $request, Ticket $ticket)
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,resolved',
        ]);

        $ticket->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', 'Status tiket berhasil diperbarui!');
    }
}
