<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuoteController extends Controller
{
    /**
     * Display quotes list with tab filtering (All Quotes vs Bookmarked Quotes).
     */
    public function index(Request $request)
    {
        $currentTab = $request->query('tab', 'all');
        $user = Auth::user();
        $editingId = $request->integer('edit', 0);

        // Load quotes with author and bookmarks relations
        $query = Quote::with(['user', 'bookmarks'])->latest();

        // If 'bookmarks' tab is selected, filter to only quotes bookmarked by the user
        if ($currentTab === 'bookmarks') {
            if (! $user) {
                return redirect()->route('login');
            }
            $query->whereHas('bookmarks', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        $quotes = $query->get();

        $myQuotes = collect();
        $otherQuotes = collect();

        if ($currentTab === 'bookmarks') {
            $bookmarkedQuotes = $quotes;
        } else {
            $bookmarkedQuotes = collect();
            if ($user) {
                $myQuotes = $quotes->where('user_id', $user->id);
                $otherQuotes = $quotes->where('user_id', '!=', $user->id);
            } else {
                $otherQuotes = $quotes;
            }
        }

        // Total count of bookmarks for the active user badge
        $bookmarksCount = $user ? $user->bookmarks()->count() : 0;

        return view('welcome', [
            'page' => $currentTab === 'bookmarks' ? 'Bookmarks' : 'Home',
            'currentTab' => $currentTab,
            'myQuotes' => $myQuotes,
            'otherQuotes' => $otherQuotes,
            'bookmarkedQuotes' => $bookmarkedQuotes,
            'bookmarksCount' => $bookmarksCount,
            'editingId' => $editingId,
        ]);
    }

    /**
     * Dedicated bookmarks page for the authenticated user (FR-08, US-08).
     */
    public function bookmarks(Request $request)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $request->merge(['tab' => 'bookmarks']);

        return $this->index($request);
    }

    /**
     * Store a newly created quote in the database.
     */
    public function store(Request $request)
    {
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to share a quote.');
        }

        $validated = $request->validate([
            'quote' => 'required|string|min:3|max:155',
        ]);

        Quote::create([
            'user_id' => Auth::id(),
            'text' => $validated['quote'],
        ]);

        return redirect()->route('home')->with('success', 'Quote added successfully.');
    }

    /**
     * Update an existing quote (author only).
     */
    public function update(Request $request, Quote $quote)
    {
        if (! Auth::check() || $quote->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'quote' => 'required|string|min:3|max:155',
        ]);

        $quote->update([
            'text' => $validated['quote'],
        ]);

        return redirect()->route('home')->with('success', 'Quote updated successfully.');
    }

    /**
     * Delete an existing quote (author only).
     */
    public function destroy(Quote $quote)
    {
        if (! Auth::check() || $quote->user_id !== Auth::id()) {
            abort(403);
        }

        $quote->delete();

        return redirect()->route('home')->with('success', 'Quote deleted successfully.');
    }
}

