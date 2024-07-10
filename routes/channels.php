<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    Log::info('App.Models.User:'.$user);
    return (int) $user->id === (int) $id;
});

Broadcast::channel('presence-video-channel', function($user) {
    Log::info('presence-video-channel:');
    return ['id' => $user->id, 'name' => $user->name];
});

// Dynamic Presence Channel for Streaming
Broadcast::channel('streaming-channel.{streamId}', function ($user) {
    Log::info('streaming-channel:');
    Log::info($user);
    return ['id' => $user->id, 'name' => $user->name];
});

// Signaling Offer and Answer Channels
Broadcast::channel('stream-signal-channel.{userId}', function ($user, $userId) {
    Log::info('stream-signal-channel:');
    Log::info($user->id);
    Log::info($userId);
    return (int) $user->id === (int) $userId;
});