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

Route::get('/analysis/{id}', 'AnalysesController@analyzeAPI');

Route::namespace('api')->group(function () {
    Route::post('/login', 'APIUserController@login');
    Route::get('/user', 'APIUserController@details')->middleware('auth:api');
});