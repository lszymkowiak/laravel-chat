<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{id}', function (User $user, $id) {
    return (int) $user->id === (int) $id;
});

// Broadcast::channel('chat', function (User $user) {
//     return ['id' => $user->id, 'name' => $user->name];
// });
