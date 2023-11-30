<?php

use App\Models\User;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

it('redirects authenticated user', function () {

    expect(User::factory()->create())->toBeRedirectedFor('/auth/login');

    // actingAs(User::factory()->create())
    //     ->get('/auth/login')
    //     ->assertStatus(302);
});

it('shows the login page')
    ->get('/auth/login')
    ->assertSeeText(['Sign in'])
    ->assertOk();

it('shows an errors if the details are not provided')
    ->post('/login')
    ->assertSessionHasErrors(['email', 'password']);

it('logs the user in', function () {
    $user = User::factory()->create([
        'password' => bcrypt('123123123')
    ]);
    post('/login', [
        'email' => $user->email,
        'password' => '123123123',
    ])
        ->assertRedirect('/');
    $this->assertAuthenticated();
});
