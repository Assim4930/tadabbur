<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    /**
     * Toggle bookmark: save the quote if not bookmarked, or remove it if already saved.
     */
    public function toggle(Quote $quote)
    {
        // Require user authentication
        if (! Auth::check()) {
            return redirect()->route('login')->with('info', 'Please log in to bookmark quotes.');
        }

        $userId = Auth::id();

        // Check if the user has already bookmarked this quote
        $bookmark = Bookmark::where('user_id', $userId)
            ->where('quote_id', $quote->id)
            ->first();

        if ($bookmark) {
            // Already bookmarked -> remove bookmark
            $bookmark->delete();
            $message = 'Quote removed from bookmarks.';
        } else {
            // Not bookmarked -> save new bookmark
            Bookmark::create([
                'user_id' => $userId,
                'quote_id' => $quote->id,
            ]);
            $message = 'Quote saved to bookmarks.';
        }

        return back()->with('success', $message);
    }
}

