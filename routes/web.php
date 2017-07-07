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
Auth::routes();
/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/', ['uses' => 'SiteController@index', 'as' => 'site.index']);

Route::post('select-regions-ajax', ['as'=>'select-regions-ajax','uses'=>'AjaxController@selectRegionsAjax']);

Route::group(['namespace' => 'Admin', 'middleware' => ['checkadmin']], function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::group(['prefix' => 'payments_types'], function () {
            Route::get('/', ['uses' => 'AdminPaymentsTypesController@index', 'as' => 'admin.paymentstypes.index']);
            Route::get('/create', ['uses' => 'AdminPaymentsTypesController@create', 'as' => 'admin.paymentstypes.create']);
            Route::post('/create', ['uses' => 'AdminPaymentsTypesController@store', 'as' => 'admin.paymentstypes.store']);
            Route::get('/edit/{paymentstype}', ['uses' => 'AdminPaymentsTypesController@edit', 'as' => 'admin.paymentstypes.edit']);
            Route::post('/edit/{paymentstype}', ['uses' => 'AdminPaymentsTypesController@update', 'as' => 'admin.paymentstypes.update']);
            Route::get('/show/{paymentstype}', ['uses' => 'AdminPaymentsTypesController@show', 'as' => 'admin.paymentstypes.show']);
            Route::get('/delete/{paymentstype}', ['uses' => 'AdminPaymentsTypesController@delete', 'as' => 'admin.paymentstypes.delete']);
        });
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', ['uses' => 'AdminUsersController@index', 'as' => 'admin.paymentstypes.index']);
            Route::get('/create', ['uses' => 'AdminUsersTypesController@create', 'as' => 'admin.users.create']);
            Route::post('/create', ['uses' => 'AdminUsersTypesController@store', 'as' => 'admin.users.store']);
            Route::get('/edit/{paymentstype}', ['uses' => 'AdminUsersController@edit', 'as' => 'admin.users.edit']);
            Route::post('/edit/{paymentstype}', ['uses' => 'AdminUsersController@update', 'as' => 'admin.users.update']);
            Route::get('/show/{paymentstype}', ['uses' => 'AdminUsersController@show', 'as' => 'admin.users.show']);
            Route::get('/delete/{paymentstype}', ['uses' => 'AdminUsersController@delete', 'as' => 'admin.users.delete']);
        });
    });
});