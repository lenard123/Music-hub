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
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->group(function(){

	Route::post('user/login', 'API\v1\Users\LoginController');

	Route::get('category', 'API\v1\Category\GetController');
	Route::get('category/{id}', 'API\v1\Category\GetController@show');
	Route::get('category/{id}/songs', 'API\v1\Category\GetController@song');

	Route::get('song', 'API\v1\Song\GetController');
	Route::get('song/{id}', 'API\v1\Song\GetController@show');

	Route::middleware('auth:api')->group(function(){
		Route::post('category', 'API\v1\Category\AddController');
		Route::put('category/{id}', 'API\v1\Category\UpdateController');
		Route::delete('category/{id}', 'API\v1\Category\DeleteController');		
		Route::post('song', 'API\v1\Song\AddController');
		Route::put('song/{id}', 'API\v1\Song\UpdateController');
		Route::delete('song/{id}', 'API\v1\Song\DeleteController');

		Route::put('user', 'API\v1\Users\UpdateController');
		Route::get('user', 'API\v1\Users\GetController');
		Route::post('user', 'API\v1\Users\AddController')->middleware('mainadmin');
	});
});
