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
Route::get('/', ['uses' => 'SiteController@welcome', 'as' => 'site.welcome']);

Route::post('select-regions-ajax', ['as' => 'select-regions-ajax', 'uses' => 'AjaxController@selectRegionsAjax']);

Route::group(['middleware' => 'auth'], function () {

    //Route::get('/', ['uses' => 'SiteController@index', 'as' => 'site.index']);
    Route::get('/surveys', ['uses' => 'SiteController@index', 'as' => 'site.index']);
    Route::get('/gotosurvey/{id}/{token}', ['uses' => 'SiteController@gotoSurvey', 'as' => 'site.goto.survey']);
    Route::group(['prefix' => 'profiles'], function () {
        Route::get('/', ['uses' => 'SiteController@indexProfiles', 'as' => 'profiles.index']);

    });
    Route::group(['prefix' => 'rewards'], function () {
        Route::get('/', ['uses' => 'BalanceController@index', 'as' => 'rewards.index']);

    });
    Route::group(['prefix' => 'withdraws'], function () {
        Route::get('/', ['uses' => 'BalanceController@indexwithdraw', 'as' => 'withdraws.index']);
        Route::post('/create', ['uses' => 'BalanceController@storeWithdraw', 'as' => 'withdraws.store']);
    });

    Route::get('/updatebalance/{id}', ['uses' => 'AjaxController@updatebalance', 'as' => 'update.balance']);

    Route::group(['prefix' => 'account'], function () {
        Route::get('/', ['uses' => 'AccountController@edit', 'as' => 'account.edit']);
        Route::post('/', ['uses' => 'AccountController@update', 'as' => 'account.update']);
    });
});

Route::group(['namespace' => 'Admin', 'middleware' => ['checkadmin']], function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', ['uses' => 'AdminSiteController@welcome', 'as' => 'admin.welcome']);
        Route::group(['prefix' => 'payments'], function () {
            Route::group(['prefix' => 'payments_types'], function () {
                Route::get('/', ['uses' => 'AdminPaymentsTypesController@index', 'as' => 'admin.paymentstypes.index']);
                Route::get('/create', ['uses' => 'AdminPaymentsTypesController@create', 'as' => 'admin.paymentstypes.create']);
                Route::post('/create', ['uses' => 'AdminPaymentsTypesController@store', 'as' => 'admin.paymentstypes.store']);
                Route::get('/edit/{paymentstype}', ['uses' => 'AdminPaymentsTypesController@edit', 'as' => 'admin.paymentstypes.edit']);
                Route::post('/edit/{paymentstype}', ['uses' => 'AdminPaymentsTypesController@update', 'as' => 'admin.paymentstypes.update']);
                Route::get('/show/{paymentstype}', ['uses' => 'AdminPaymentsTypesController@show', 'as' => 'admin.paymentstypes.show']);
                Route::get('/delete/{paymentstype}', ['uses' => 'AdminPaymentsTypesController@delete', 'as' => 'admin.paymentstypes.delete']);
            });
            Route::group(['prefix' => 'withdraws'], function () {
                Route::get('/', ['uses' => 'AdminWithdrawsController@index', 'as' => 'admin.withdraws.index']);
                Route::get('/create', ['uses' => 'AdminWithdrawsController@create', 'as' => 'admin.withdraws.create']);
                Route::post('/create', ['uses' => 'AdminWithdrawsController@store', 'as' => 'admin.withdraws.store']);
                Route::get('/edit/{withdraw}', ['uses' => 'AdminWithdrawsController@edit', 'as' => 'admin.withdraws.edit']);
                Route::post('/edit/{withdraw}', ['uses' => 'AdminWithdrawsController@update', 'as' => 'admin.withdraws.update']);
                Route::post('/status/edit', ['uses' => 'AdminWithdrawsController@updateStatus', 'as' => 'admin.withdraws.status.update']);
                Route::get('/show/{withdraw}', ['uses' => 'AdminWithdrawsController@show', 'as' => 'admin.withdraws.show']);
                Route::get('/delete/{withdraw}', ['uses' => 'AdminWithdrawsController@delete', 'as' => 'admin.withdraws.delete']);
            });
        });
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', ['uses' => 'AdminUsersController@index', 'as' => 'admin.users.index']);
            Route::get('/create', ['uses' => 'AdminUsersTypesController@create', 'as' => 'admin.users.create']);
            Route::post('/create', ['uses' => 'AdminUsersTypesController@store', 'as' => 'admin.users.store']);
            Route::get('/edit/{user}', ['uses' => 'AdminUsersController@edit', 'as' => 'admin.users.edit']);
            Route::post('/edit/{user}', ['uses' => 'AdminUsersController@update', 'as' => 'admin.users.update']);
            Route::get('/show/{user}', ['uses' => 'AdminUsersController@show', 'as' => 'admin.users.show']);
            Route::get('/delete/{user}', ['uses' => 'AdminUsersController@delete', 'as' => 'admin.users.delete']);
        });

    });
});