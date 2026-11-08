<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('admins.{id}', function ($admin, $id) {
    return (int) $admin->id === (int) $id;
} , ['guards'=>['admin']]); //the guard is the name of the guard in the config/auth.php file

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


