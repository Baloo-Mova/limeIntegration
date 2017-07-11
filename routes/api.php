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
Route::get('/actualRegions/{countryId}', ["uses" => "AjaxController@getRegionsInfo", "as" => "get.regions.info"]);
Route::get('/actualCities/{countryId}', ["uses" => "AjaxController@getCitiesInfo", "as" => "get.cities.info"]);
Route::get('/test', ["uses" => "AjaxController@updatebalance", "as" => "update.balance.info"]);
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
