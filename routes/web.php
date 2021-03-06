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
	return response()->json('API Works');
	
});

// API route group that we need to protect
Route::group(['prefix' => 'api', 'middleware' => ['jwt.auth','laravel-acl']], function()
{
	Route::group('level' => 'admin', 'permission'    => 'admin.users', function(){
		Route::post('role', 'JwtAuthenticateController@createRole');
		// Route to create a new permission
		Route::post('permission', 'JwtAuthenticateController@createPermission');
		// Route to assign role to user
		Route::post('assign-role', 'JwtAuthenticateController@assignRole');
		// Route to attache permission to a role
		Route::post('attach-permission', 'JwtAuthenticateController@attachPermission');
		// Protected route
		Route::get('users', 'JwtAuthenticateController@index');

	});

	Route::group('level' => 'user', function(){
		Route::get('user', 'UserController@index');
	});
});


// Authentication route
Route::post('authenticate', 'JwtAuthenticateController@authenticate');
Route::post('register','JwtAuthenticateController@register');
