<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'text',
    ];

    /**
     * The author of the quote.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Bookmark records associated with this quote.
     */
    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    /**
     * Users who bookmarked this quote.
     */
    public function bookmarkedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'bookmarks')->withTimestamps();
    }

    /**
     * Helper to check if a specific user has bookmarked this quote.
     */
    public function isBookmarkedBy(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        // Use loaded collection if available to avoid extra SQL queries
        if ($this->relationLoaded('bookmarks')) {
            return $this->bookmarks->contains('user_id', $user->id);
        }

        return $this->bookmarks()->where('user_id', $user->id)->exists();
    }
}

