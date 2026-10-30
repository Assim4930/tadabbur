<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations: create bookmarks table to store saved quotes per user.
     */
    public function up(): void
    {
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // User who bookmarked
            $table->foreignId('quote_id')->constrained()->cascadeOnDelete(); // Bookmarked quote
            $table->timestamps();

            // Ensure a user cannot bookmark the same quote more than once
            $table->unique(['user_id', 'quote_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookmarks');
    }
};

