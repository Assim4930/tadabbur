<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

test('guest can register with valid name email and password (FR-02, US-02)', function () {
    $response = $this->post(route('signup.store'), [
        'name' => 'Fahad Alotaibi',
        'email' => 'fahad@example.com',
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
    ]);

    $response->assertRedirect('/');
    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'email' => 'fahad@example.com',
        'name' => 'Fahad Alotaibi',
    ]);

    $user = User::where('email', 'fahad@example.com')->first();
    // NFR-02: Passwords shall be stored hashed, never as plain text
    expect(Hash::check('secret123', $user->password))->toBeTrue();
    expect($user->password)->not->toBe('secret123');
});

test('registration rejects invalid name with numbers or symbols (FR-02, US-02)', function () {
    $response = $this->post(route('signup.store'), [
        'name' => 'John123#',
        'email' => 'john@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertSessionHasErrors('name');
    $this->assertGuest();
});

test('registration rejects password shorter than 8 characters (FR-02, US-02)', function () {
    $response = $this->post(route('signup.store'), [
        'name' => 'Sara Smith',
        'email' => 'sara@example.com',
        'password' => 'pass',
        'password_confirmation' => 'pass',
    ]);

    $response->assertSessionHasErrors('password');
    $this->assertGuest();
});

test('registration rejects existing email (FR-02, US-02)', function () {
    User::factory()->create(['email' => 'existing@example.com']);

    $response = $this->post(route('signup.store'), [
        'name' => 'Duplicate User',
        'email' => 'existing@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});

test('registered user can log in with valid credentials (FR-03, US-03)', function () {
    $user = User::factory()->create([
        'email' => 'loginuser@example.com',
        'password' => Hash::make('mypassword123'),
    ]);

    $response = $this->post(route('login.store'), [
        'email' => 'loginuser@example.com',
        'password' => 'mypassword123',
    ]);

    $response->assertRedirect('/');
    $this->assertAuthenticatedAs($user);
});

test('user cannot log in with invalid credentials (FR-03, US-03)', function () {
    User::factory()->create([
        'email' => 'correct@example.com',
        'password' => Hash::make('correctpassword'),
    ]);

    $response = $this->from(route('login'))->post(route('login.store'), [
        'email' => 'correct@example.com',
        'password' => 'wrongpassword',
    ]);

    $response->assertRedirect(route('login'));
    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});

test('logged-in user can log out (FR-04, US-04)', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('logout'));

    $response->assertRedirect('/');
    $this->assertGuest();
});

