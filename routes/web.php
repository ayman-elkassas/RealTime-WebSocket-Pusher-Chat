<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    broadcast(new \App\Events\EventWebSocketMessage('My Data'));
    return view('welcome');
});

//TODO:how to create auth scaffolding in laravel 6 and up
//composer require laravel/ui
//php artisan ui vue --auth
//npm install
//npm run dev
//php artisan cache:clear
//php artisan view:clear

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//chat routes
Route::get('chats','ChatController@index');
Route::get('messages','ChatController@getMessages');
Route::post('messages','ChatController@saveMessage');

