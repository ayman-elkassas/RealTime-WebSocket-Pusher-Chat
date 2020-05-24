<?php

use Illuminate\Support\Facades\Broadcast;

//TODO:*****************Note VI********************************************
//Every private channel and presence channel are private channels
//each one should authorized with broadcast user on it not channel public
//should be register in channel.php file

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

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

//to register your channel until every one can listen on channel and receive call trigger back
//when event on this channel firing

//PRESENCE CHANNEL IS A PRIVATE CHANNEL
Broadcast::channel('chats', function ($user){
    //should handle code to verify user want to subscribe and begin listen
    //this way (return user) anyone can listen on chats channel
    return $user;
});
