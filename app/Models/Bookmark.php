<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Represents a saved quote (bookmark) by a user.
 */
class Bookmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quote_id',
    ];

    /**
     * The user who saved this bookmark.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The quote that was bookmarked.
     */
    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class);
    }
}

