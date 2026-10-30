<?php

use App\Models\Quote;
use App\Models\User;

test('guest can view all quotes with author name and date without edit or delete options (FR-01, US-01)', function () {
    $user = User::factory()->create(['name' => 'Alice']);
    $quote = Quote::create([
        'user_id' => $user->id,
        'text' => 'Inspiring quote for everyone to see',
    ]);

    $response = $this->get(route('home'));

    $response->assertStatus(200);
    $response->assertSee('Inspiring quote for everyone to see');
    $response->assertSee('Alice');
    $response->assertSee($quote->created_at->format('M d, Y'));
    // Guest should not see edit or delete options (FR-01, US-01)
    $response->assertDontSee('edit=' . $quote->id);
    $response->assertDontSee('⌫');
    $response->assertSee('Log in to share a quote');
});

test('authenticated user can share a quote of 3 to 155 characters (FR-05, US-05)', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('quotes.store'), [
        'quote' => 'This is a test quote created by user.',
    ]);

    $response->assertRedirect(route('home'));
    $this->assertDatabaseHas('quotes', [
        'user_id' => $user->id,
        'text' => 'This is a test quote created by user.',
    ]);
});

test('quote shorter than 3 or longer than 155 characters is rejected (FR-05, US-05)', function () {
    $user = User::factory()->create();

    // Shorter than 3
    $shortResponse = $this->actingAs($user)->post(route('quotes.store'), [
        'quote' => 'Hi',
    ]);
    $shortResponse->assertSessionHasErrors('quote');

    // Longer than 155
    $longText = str_repeat('a', 156);
    $longResponse = $this->actingAs($user)->post(route('quotes.store'), [
        'quote' => $longText,
    ]);
    $longResponse->assertSessionHasErrors('quote');
});

test('guest cannot create quote and is redirected to login', function () {
    $response = $this->post(route('quotes.store'), [
        'quote' => 'Unauthorized quote',
    ]);

    $response->assertRedirect(route('login'));
});

test('user can update their own quote (FR-06, US-06)', function () {
    $user = User::factory()->create();
    $quote = Quote::create([
        'user_id' => $user->id,
        'text' => 'Original text before editing',
    ]);

    $response = $this->actingAs($user)->put(route('quotes.update', $quote), [
        'quote' => 'Updated text after editing',
    ]);

    $response->assertRedirect(route('home'));
    $this->assertDatabaseHas('quotes', [
        'id' => $quote->id,
        'text' => 'Updated text after editing',
    ]);
});

test('user cannot update someone else quote (FR-06, NFR-03)', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();

    $quote = Quote::create([
        'user_id' => $owner->id,
        'text' => 'Original quote text',
    ]);

    $response = $this->actingAs($other)->put(route('quotes.update', $quote), [
        'quote' => 'Hacked text',
    ]);

    $response->assertStatus(403);
});

test('user can delete their own quote immediately (FR-07, US-07)', function () {
    $user = User::factory()->create();

    $quote = Quote::create([
        'user_id' => $user->id,
        'text' => 'Quote to be deleted',
    ]);

    $response = $this->actingAs($user)->delete(route('quotes.destroy', $quote));

    $response->assertRedirect(route('home'));
    $this->assertDatabaseMissing('quotes', [
        'id' => $quote->id,
    ]);
});

test('user cannot delete someone else quote (FR-07, NFR-03)', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();

    $quote = Quote::create([
        'user_id' => $owner->id,
        'text' => 'Protected quote text',
    ]);

    $response = $this->actingAs($other)->delete(route('quotes.destroy', $quote));

    $response->assertStatus(403);
    $this->assertDatabaseHas('quotes', [
        'id' => $quote->id,
    ]);
});
