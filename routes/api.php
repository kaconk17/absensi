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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'UserController@login');
Route::middleware('ApiAuth')->group(function () {
    Route::get('/user/location/{id}', 'UserController@mylocation');
    Route::get('/user/profile/{id}', 'UserController@profile');
    Route::post('/absen/create', 'AbsenController@create');
    Route::get('/absen/getabsen/{id}', 'AbsenController@getAbsen');
    Route::put('/user/update/{id}', 'UserController@sethomelocation');
});
