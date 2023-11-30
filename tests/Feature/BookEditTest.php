<?php

use App\Models\Book;
use App\Models\User;

it('redirect unauthenticated users')
    ->expectGuest()->toBeRedirectedFor('/books/1/edit');

it('shows the book details in the form', function () {
    $user = User::factory()->create();

    $user->books()->attach($book = Book::factory()->create(), [
        'status' => 'READING'
    ]);

    actingAs($user)
        ->get('/books/' . $book->id . '/edit')
        ->assertOk()
        ->assertSee([$book->title, $book->author])
        ->assertSee('<option value="READING" selected>Reading</option>', false);
});

it('fails if the user does not own the book', function () {
    $user = User::factory()->create();
    $user2 = User::factory()->create();

    $user2->books()->attach($book = Book::factory()->create(), [
        'status' => 'READING'
    ]);

    actingAs($user)
        ->get('/books/' . $book->id . '/edit')
        ->assertStatus(403);
});
