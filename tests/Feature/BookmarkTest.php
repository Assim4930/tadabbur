<?php

use App\Models\Bookmark;
use App\Models\Quote;
use App\Models\User;

test('guest cannot bookmark a quote and is redirected to login', function () {
    $author = User::factory()->create();
    $quote = Quote::create([
        'user_id' => $author->id,
        'text' => 'First test quote text',
    ]);

    $response = $this->post(route('quotes.bookmark', $quote));

    $response->assertRedirect(route('login'));
    expect(Bookmark::count())->toBe(0);
});

test('authenticated user can bookmark and unbookmark a quote', function () {
    $user = User::factory()->create();
    $quote = Quote::create([
        'user_id' => $user->id,
        'text' => 'Sample inspiring quote',
    ]);

    // Bookmark
    $response = $this->actingAs($user)->post(route('quotes.bookmark', $quote));
    $response->assertSessionHas('success');
    expect(Bookmark::where('user_id', $user->id)->where('quote_id', $quote->id)->exists())->toBeTrue();
    expect($quote->isBookmarkedBy($user))->toBeTrue();

    // Toggle (Unbookmark)
    $response = $this->actingAs($user)->post(route('quotes.bookmark', $quote));
    $response->assertSessionHas('success');
    expect(Bookmark::where('user_id', $user->id)->where('quote_id', $quote->id)->exists())->toBeFalse();
    expect($quote->isBookmarkedBy($user))->toBeFalse();
});

test('bookmarks tab shows bookmarked quotes', function () {
    $user = User::factory()->create();
    $quote1 = Quote::create([
        'user_id' => $user->id,
        'text' => 'Bookmarked quote test',
    ]);
    $quote2 = Quote::create([
        'user_id' => $user->id,
        'text' => 'Not bookmarked quote',
    ]);

    Bookmark::create([
        'user_id' => $user->id,
        'quote_id' => $quote1->id,
    ]);

    $response = $this->actingAs($user)->get(route('home', ['tab' => 'bookmarks']));

    $response->assertStatus(200);
    $response->assertSee('Bookmarked quote test');
    $response->assertDontSee('Not bookmarked quote');
});

test('dedicated bookmarks page loads bookmarked quotes for authenticated user', function () {
    $user = User::factory()->create();
    $quote = Quote::create([
        'user_id' => $user->id,
        'text' => 'Saved in personal bookmarks page',
    ]);

    Bookmark::create([
        'user_id' => $user->id,
        'quote_id' => $quote->id,
    ]);

    $response = $this->actingAs($user)->get(route('bookmarks'));

    $response->assertStatus(200);
    $response->assertSee('Saved in personal bookmarks page');
    $response->assertSee('Bookmarks');
});

test('guest visiting dedicated bookmarks page is redirected to login', function () {
    $response = $this->get(route('bookmarks'));

    $response->assertRedirect(route('login'));
});

test('user cannot view another user bookmarks (FR-09, NFR-06)', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();

    $quoteUserA = Quote::create([
        'user_id' => $userA->id,
        'text' => 'Quote bookmarked by User A only',
    ]);

    $quoteUserB = Quote::create([
        'user_id' => $userB->id,
        'text' => 'Quote bookmarked by User B only',
    ]);

    Bookmark::create(['user_id' => $userA->id, 'quote_id' => $quoteUserA->id]);
    Bookmark::create(['user_id' => $userB->id, 'quote_id' => $quoteUserB->id]);

    // User A should see only their own bookmark
    $responseA = $this->actingAs($userA)->get(route('bookmarks'));
    $responseA->assertSee('Quote bookmarked by User A only');
    $responseA->assertDontSee('Quote bookmarked by User B only');

    // User B should see only their own bookmark
    $responseB = $this->actingAs($userB)->get(route('bookmarks'));
    $responseB->assertSee('Quote bookmarked by User B only');
    $responseB->assertDontSee('Quote bookmarked by User A only');
});
