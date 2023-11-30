<?php

use App\Models\Pivot\BookUser;
use App\Models\User;

it('only allows authenticated users to create a new post')
    ->expectGuest()->toBeRedirectedFor('/books/create');
//    ->get('/books/create')
//    ->assertStatus(302);

it('shows the available statuses on the form', function () {
    $user= User::factory()->create();
    $this->actingAs($user)
        ->get('books/create')
        ->assertSeeTextInOrder(BookUser::$statuses);
});

