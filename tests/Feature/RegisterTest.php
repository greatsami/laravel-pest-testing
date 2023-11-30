<?php

use App\Models\User;
use function Pest\Laravel\post;

it('redirects authenticated user', function () {

    expect(User::factory()->create())->toBeRedirectedFor('/auth/register');

    // actingAs(User::factory()->create())
    //     ->get('/auth/login')
    //     ->assertStatus(302);
});

it('show the register page')->get('/auth/register')->assertStatus(200);

it('has errors if the details are not provided')
    ->post('/register')
    ->assertSessionHasErrors(['name', 'email', 'password']);

it('registers the user')
    ->defer(function () {
        $this->post('/register', [
            'name' => 'Sami Mansour',
            'email' => 'sami@gmail.com',
            'password' => 'password'
        ])
            ->assertRedirect('/');
    })->assertDatabaseHas('users', [
        'name' => 'Sami Mansour',
        'email' => 'sami@gmail.com',
    ])
    ->assertAuthenticated();
