<?php

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
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/home/invite', 'FriendsController@invite_view')->name('invite_view');
Route::get('autocomplete', 'FriendsController@autocomplete')->name('autocomplete');
Route::post('/home/invite', 'FriendsController@process_invites')->name('process_invite');


//invites
Route::get('/friendsregistration/{token}', 'FriendsController@registration_view')->name('friendsregistration');
Route::POST('/friendsregistration', 'Auth\FriendsRegisterController@registers')->name('accept');
