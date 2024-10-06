<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('chat-channel.{currentUserId}', function (User $user,$currentUserId) { 
    return $user->id === (int) $currentUserId;  // Authorize the user
});

Broadcast::channel('online-users', function (User $user) { 
    return $user->only('id','name');
});
