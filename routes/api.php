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
Route::post('/get-survey-questions', ["uses" => "AjaxController@getSurveyQuestions", "as" => "get.survey.questions"]);
Route::post('/get-questions-answers', ["uses" => "AjaxController@getSurveyQuestionsAnswers", "as" => "get.survey.questions.answers"]);
Route::post('/get-participants', ["uses" => "AjaxController@getSurveyParticipants", "as" => "get.survey.participants"]);
Route::post('/get-list-participants', ["uses" => "AjaxController@getListParticipants", "as" => "get.list.participants"]);
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
