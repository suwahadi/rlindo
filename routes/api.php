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

Route::middleware('auth:api')->get('/users', function () {
    return \App\User::all();
});

Route::get('cv', 'CVController@index');
Route::get('cv/{slug}', 'CVController@show');

Route::get('exp', 'EXPController@index');
Route::get('exp/{slug}', 'EXPController@show');

Route::get('listcertificates', 'ListCertificatesController@index');
Route::get('listcertificates/{slug}', 'ListCertificatesController@show');

Route::get('listskills', 'ListSkillsController@index');