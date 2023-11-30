<?php

use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('only allows authenticated users to post')
    ->expectGuest()->toBeRedirectedFor('/books', 'post');
//    ->post('/books')
//    ->assertStatus(302);



it('creates a book', function () {

    $this->actingAs($this->user)
        ->post('books', [
            'title'=> 'A Book',
            'author'=> 'An Author',
            'status'=> 'WANT_TO_READ',
        ]);

    $this->assertDatabaseHas('books', [
        'title'=> 'A Book',
        'author'=> 'An Author',
    ]);
    $this->assertDatabaseHas('book_user', [
        'user_id'=> $this->user->id,
        'status'=> 'WANT_TO_READ',
    ]);
});

it('requires a book title, author, and status')
    ->defer(fn () => $this->actingAs($this->user))
    ->post('/books')->assertSessionHasErrors(['title', 'author', 'status']);


it('requires a valid status')
    ->defer(fn() => $this->actingAs($this->user))
    ->post('/books', [
        'status' => 'EATING'
    ])
    ->assertSessionHasErrors(['status']);
