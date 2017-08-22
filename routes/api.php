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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Route::middleware('auth:api')->post('/users', [ 'uses' => 'ApiController@getUsers' ] );


Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function(){

    Route::post('users',"ApiController@getUsers");

    Route::post('change-user-status',"ApiController@changeUserStatus");

    Route::post('get-user-times',"ApiController@getUsersTimes");

    Route::post('save-user-color',"ApiController@saveUserColor");

});
