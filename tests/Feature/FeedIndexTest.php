<?php

use App\Models\Book;
use App\Models\User;

it('only allows authenticated users to feed')
    ->expectGuest()->toBeRedirectedFor('/feed');

it('can get books of friends', function () {
    $user = User::factory()->create();
    $friendOne = User::factory()->create();
    $friendTwo = User::factory()->create();

    $friendOne->books()->attach($bookOne = Book::factory()->create(), [
        'status' => 'READING',
        'updated_at' => now()->subDay()
    ]);

    $friendTwo->books()->attach($bookTwo = Book::factory()->create(), [
        'status' => 'WANT_TO_READ',
    ]);

    $user->addFriend($friendOne);
    $friendOne->acceptFriend($user);

    $friendTwo->addFriend($user);
    $user->acceptFriend($friendTwo);

    actingAs($user)
        ->get('/feed')
        ->assertSeeInOrder([
            $friendTwo->name . ' want to read ' . $bookTwo->title,
            $friendOne->name . ' is reading ' . $bookOne->title,
        ]);

});
