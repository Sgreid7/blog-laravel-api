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

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/posts', 'PostsController@index');
    Route::post('/posts', 'PostsController@store');
    Route::put('/posts/{post}', 'PostsController@update');
    Route::delete('/posts/{post}', 'PostsController@destroy');

    Route::post('/logout', 'AuthController@logout');
});


Route::post('/login', 'AuthController@login');
Route::post('/signup', 'AuthController@signup');
