<?php

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

use App\Models\User;

Broadcast::channel('devices', function (User $user) {
    return $user->hasGlobalRead();
});

Broadcast::channel('devices.{device_id}', function (User $user, $device_id) {
    return $user->canAccessDevice($device_id);
});

Broadcast::channel('settings', function (User $user) {
    return $user->isAdmin();
});

Broadcast::channel('settings.{setting}', function (User $user, $setting) {
    $private = collect(); // TODO: define list of sensitive settings
    if ($private->contains($setting)) {
        return $user->isAdmin();
    }

    return true;
});
