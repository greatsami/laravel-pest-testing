<?php

use App\Models\User;

it('redirects unauthenticated users')
    ->expectGuest()->toBeRedirectedFor('/friends');

it('shows a list of the user pending friends', function () {
    $user = User::factory()->create();
    $friends = User::factory(2)->create();

    $friends->each(fn ($friend) => $user->addFriend($friend));

    actingAs($user)
        ->get('/friends')
        ->assertOk()
        ->assertSeeInOrder(array_merge(['Pending friend requests'], $friends->pluck('name')->toArray()));
});

it('shows a list of users friend request', function () {
    $user = User::factory()->create();
    $friends = User::factory(2)->create();

    $friends->each(fn ($friend) => $friend->addFriend($user));

    actingAs($user)
        ->get('/friends')
        ->assertOk()
        ->assertSeeInOrder(array_merge(['Friend requests'], $friends->pluck('name')->toArray()));
});

it('shows a list of users accepted friends', function () {
    $user = User::factory()->create();
    $friends = User::factory(2)->create();

    $friends->each(function ($friend) use ($user) {
        $user->addFriend($friend);
        $friend->acceptFriend($user);
    });

    actingAs($user)
        ->get('/friends')
        ->assertOk()
        ->assertSeeInOrder(array_merge(['Friends'], $friends->pluck('name')->toArray()));
});
