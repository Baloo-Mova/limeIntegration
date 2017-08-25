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


Route::get('/redirect', ['uses' => 'Auth\SocialController@redirectFaceBook', 'as' => 'facebook.socialite.redirect']);
Route::get('/callback', ['uses' => 'Auth\SocialController@callbackFaceBook', 'as' => 'facebook.socialite.callback']);

Route::get('/', ['uses' => 'SiteController@welcome', 'as' => 'site.welcome']);
Route::get('/need-verify-email', ['uses' => 'SiteController@needVerifyEmail', 'as' => 'need.verify.email']);
Route::get('/verify-email/{user_id}/{token}', ['uses' => 'SiteController@verifyEmail', 'as' => 'verify.email']);
Route::get('/verify-email-success', ['uses' => 'SiteController@verifyEmailSuccess', 'as' => 'verify.email.success']);
Route::get('/verify-repeat/{user_id}', ['uses' => 'SiteController@verifyEmailRepeat', 'as' => 'verify.email.repeat']);

Route::post('select-regions-ajax', ['as' => 'select-regions-ajax', 'uses' => 'AjaxController@selectRegionsAjax']);
Route::get('error/{error}', ['uses' => 'SiteController@error', 'as' => 'error']);
Route::group(['middleware' => ['auth', 'checkFull', 'emailVerified']], function () {
    Route::get('/surveys', ['uses' => 'SiteController@index', 'as' => 'site.index']);
    Route::get('/change-locale/{locale}', ['uses' => 'SiteController@changeLocale', 'as' => 'site.change.locale']);
    Route::get('/gotosurvey/{id}/{token}', ['uses' => 'SiteController@gotoSurvey', 'as' => 'site.goto.survey']);
    Route::group(['prefix' => 'profiles'], function () {
        Route::get('/', ['uses' => 'SiteController@indexProfiles', 'as' => 'profiles.index']);

    });
    Route::group(['prefix' => 'rewards'], function () {
        Route::get('/', ['uses' => 'BalanceController@index', 'as' => 'rewards.index']);
        Route::get('/balance', ['uses' => 'BalanceController@balance', 'as' => 'rewards.balance']);

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

    Route::group(['prefix' => 'messages'], function () {
        Route::get('/', ['uses' => 'MessagesController@index', 'as' => 'messages.index']);
        Route::get('/show/{mid}', ['uses' => 'MessagesController@show', 'as' => 'messages.show']);
    });

    Route::get('/pages/{pageName}', ['uses' => 'PagesController@pageView', 'as' => 'pages.view']);
});

Route::group(['namespace' => 'Admin', 'middleware' => ['checkadmin']], function () {
    Route::group(['prefix' => 'admin'], function () {


        Route::get('/getUsers', ['uses' => 'AdminSurveysProcessingController@getUsers', 'as' => 'admin.get.users']);
        Route::get('/getUsersByName', ['uses' => 'AdminWithdrawsController@getUsers', 'as' => 'admin.get.users.by.name']);

        Route::get('/', ['uses' => 'AdminSiteController@welcome', 'as' => 'admin.welcome']);

        Route::group(['prefix'=>'settings'],function(){
            Route::get('/',['uses'=>'AdminSettings@index','as'=>'admin.settings']);
            Route::post('/',['uses'=>'AdminSettings@store','as'=>'admin.settings.store']);
            Route::post('/save-smtp',['uses'=>'AdminSettings@saveSmtp','as'=>'admin.settings.save.smtp']);
            Route::post('/check-smtp',['uses'=>'AdminSettings@checkSmtp','as'=>'admin.settings.check.smtp']);
        });

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
            Route::group(['prefix' => 'withdraws', 'middleware' => ['admin']], function () {
                Route::get('/{column}/{direction}', ['uses' => 'AdminWithdrawsController@index', 'as' => 'admin.withdraws.index']);
                Route::get('/create', ['uses' => 'AdminWithdrawsController@create', 'as' => 'admin.withdraws.create']);
                Route::post('/create', ['uses' => 'AdminWithdrawsController@store', 'as' => 'admin.withdraws.store']);
                Route::get('/edit/{withdraw}', ['uses' => 'AdminWithdrawsController@edit', 'as' => 'admin.withdraws.edit']);
                Route::post('/edit/{withdraw}', ['uses' => 'AdminWithdrawsController@update', 'as' => 'admin.withdraws.update']);
                Route::post('/status/edit', ['uses' => 'AdminWithdrawsController@updateStatus', 'as' => 'admin.withdraws.status.update']);
                Route::get('/show/{withdraw}', ['uses' => 'AdminWithdrawsController@show', 'as' => 'admin.withdraws.show']);
                Route::get('/delete/{withdraw}', ['uses' => 'AdminWithdrawsController@delete', 'as' => 'admin.withdraws.delete']);
                Route::get('/export', ['uses' => 'AdminWithdrawsController@export', 'as' => 'admin.withdraws.export']);
                Route::post('/export', ['uses' => 'AdminWithdrawsController@exportCsv', 'as' => 'admin.withdraws.export.csv']);
            });
        });
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', ['uses' => 'AdminUsersController@index', 'as' => 'admin.users.index']);
            Route::get('/create', ['uses' => 'AdminUsersTypesController@create', 'as' => 'admin.users.create']);
            Route::post('/create', ['uses' => 'AdminUsersTypesController@store', 'as' => 'admin.users.store']);
            Route::get('/edit/{user}', ['uses' => 'AdminUsersController@edit', 'as' => 'admin.users.edit']);
            Route::post('/edit/{user}', ['uses' => 'AdminUsersController@update', 'as' => 'admin.users.update']);
            Route::get('/show/{user}', ['uses' => 'AdminUsersController@show', 'as' => 'admin.users.show']);
            Route::get('/show-by-pid/{pid}', ['uses' => 'AdminUsersController@showByPid', 'as' => 'admin.users.show.pid']);
            Route::get('/delete/{user}', ['uses' => 'AdminUsersController@delete', 'as' => 'admin.users.delete']);
            Route::get('/export', ['uses' => 'AdminUsersController@export', 'as' => 'admin.users.export']);
            Route::post('/export', ['uses' => 'AdminUsersController@findIndex', 'as' => 'admin.users.find.index']);
            Route::post('/export-users', ['uses' => 'AdminUsersController@exportUsers', 'as' => 'admin.users.export.csv']);
            Route::get('/export-users-all', ['uses' => 'AdminUsersController@exportUsersAll', 'as' => 'admin.users.export.all']);
        });

        Route::group(['prefix' => 'surveys'], function () {
            Route::get('/', ['uses' => 'AdminSurveysController@index', 'as' => 'admin.surveys.index']);
            Route::get('/convert-to-worksheet/{sid}/{type}', ['uses' => 'AdminSurveysController@convertToWorksheet', 'as' => 'admin.surveys.convertToWorksheet']);
            Route::post('/change-reward', ['uses' => 'AdminSurveysController@changeReward', 'as' => 'admin.surveys.change.rewards']);
            Route::get('/statistics', ['uses' => 'AdminSurveysController@statistics', 'as' => 'admin.surveys.statistics']);
            Route::get('/remind/{sid}', ['uses' => 'AdminSurveysController@remind', 'as' => 'admin.surveys.remind']);
            Route::get('/to-all/{sid}', ['uses' => 'AdminSurveysController@toAll', 'as' => 'admin.surveys.to.all']);
        });

        Route::group(['prefix' => 'messages', 'middleware' => ['admin']], function () {
            Route::get('/', ['uses' => 'AdminMessagesController@index', 'as' => 'admin.messages.index']);
            Route::post('/', ['uses' => 'AdminMessagesController@findIndex', 'as' => 'admin.messages.find.index']);
            Route::post('/send-message-by-pids', ['uses' => 'AdminMessagesController@sendMessageByPids', 'as' => 'admin.messages.pids']);




            Route::get('/message-create', ['uses' => 'AdminMessagesController@createMessage', 'as' => 'admin.messages.create']);
            Route::post('/message-create', ['uses' => 'AdminMessagesController@sendBaseMessage', 'as' => 'admin.send.base.messages']);
            Route::post('/message-to-list', ['uses' => 'AdminMessagesController@sendBaseMessageToList', 'as' => 'admin.send.base.messages.list']);
            Route::get('/email-message-create', ['uses' => 'AdminMessagesController@createEmailMessage', 'as' => 'admin.messages.email']);
            Route::post('/email-message-create', ['uses' => 'AdminMessagesController@sendEmailMessage', 'as' => 'admin.messages.send.email']);
        });

        Route::group(['prefix' => 'pages'], function () {
            Route::get('/', ['uses' => 'AdminPagesController@index', 'as' => 'admin.pages.index']);
            Route::get('/create', ['uses' => 'AdminPagesController@create', 'as' => 'admin.pages.create']);
            Route::post('/create', ['uses' => 'AdminPagesController@store', 'as' => 'admin.pages.store']);
            Route::get('/delete/{id}', ['uses' => 'AdminPagesController@delete', 'as' => 'admin.pages.delete']);
            Route::get('/show/{id}', ['uses' => 'AdminPagesController@show', 'as' => 'admin.pages.show']);
            Route::get('/edit/{id}', ['uses' => 'AdminPagesController@edit', 'as' => 'admin.pages.edit']);
            Route::post('/edit/{id}', ['uses' => 'AdminPagesController@update', 'as' => 'admin.pages.update']);
        });

        Route::group(['prefix' => 'manage'], function () {
            Route::get('/', ['uses' => 'AdminManageSurveyParticipantsController@index', 'as' => 'admin.manage.index']);
            Route::post('/', ['uses' => 'AdminManageSurveyParticipantsController@findIndex', 'as' => 'admin.manage.find.index']);



            Route::get('/add-participant-to-survey', ['uses' => 'AdminManageSurveyParticipantsController@addParticipant', 'as' => 'admin.manage.addParticipant']);
            Route::post('/add-participant-to-survey', ['uses' => 'AdminManageSurveyParticipantsController@saveParticipant', 'as' => 'admin.manage.saveParticipant']);
            Route::post('/add-participant-to-survey-list', ['uses' => 'AdminManageSurveyParticipantsController@addListParticipants', 'as' => 'admin.manage.addListParticipant']);
        });

        Route::group(['prefix' => 'processing'], function () {
            Route::get('/', ['uses' => 'AdminSurveysProcessingController@index', 'as' => 'admin.surveys.processing.index']);
            Route::post('/finished-worksheets', ['uses' => 'AdminSurveysProcessingController@finishedWorksheets', 'as' => 'admin.surveys.processing.finished.worksheets']);
            Route::post('/not-finished-worksheets', ['uses' => 'AdminSurveysProcessingController@notFinishedWorksheets', 'as' => 'admin.surveys.processing.not.finished.worksheets']);
            Route::post('/all-worksheets', ['uses' => 'AdminSurveysProcessingController@allWorksheets', 'as' => 'admin.surveys.processing.all.worksheets']);
        });

    });
});