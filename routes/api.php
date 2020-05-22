<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');
header('Access-Control-Expose-Headers:Authorization');

Route::prefix('auth')->group(function () {
    // Below mention routes are public, user can access those without any restriction.
    // Create New User
    Route::post('register', 'AuthController@register');
    // Login User
    Route::post('login', 'AuthController@login');
    
    // Refresh the JWT Token
    Route::get('refresh', 'AuthController@refresh');
    
    // Below mention routes are available only for the authenticated users.
    Route::middleware('auth:api')->group(function () {
        // Get user info
        Route::get('user', 'AuthController@user');
        // Logout user from application
        Route::post('logout', 'AuthController@logout');
    });
});

Route::get('getchat', 'ChatController@index')->name('get.chat');
Route::post('addchat', 'ChatController@store')->name('add.chat');
Route::post('updatechat/{id}', 'ChatController@update')->name('update.chat');

Route::post('getmsgbychat', 'MessageController@index')->name('get.msg');
Route::post('addmsg', 'MessageController@store')->name('add.msg');
Route::post('messages/{id}', 'MessageController@update')->name('update.msg');
Route::delete('messages/{id}', 'MessageController@destroy')->name('delete.msg');

Route::get('users', 'UserController@index')->name('get.users');

Route::post('adduserchat', 'UsersChatsController@store')->name('add.userchat');
Route::post('getByChat/{id}', 'UsersChatsController@index')->name('get.userchat');
Route::delete('userchat/{id}', 'UsersChatsController@destroy')->name('delete.userchat');
Route::post('getUsers/{id}', 'UsersChatsController@get')->name('getusers.notchat');