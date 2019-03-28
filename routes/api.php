<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
/* */

// Route::resource('users', 'AdminUserController')->parameters([
//     'users' => 'admin_user'
// ]) 

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('v01/user/red/{id}', 'API\RedesController@getreduser');
Route::put('v01/user/imagen/{id}', 'API\UsersController@changeimage');
Route::apiResource('v01/users', 'API\UsersController');
Route::apiResource('v01/redes', 'API\RedesController');
