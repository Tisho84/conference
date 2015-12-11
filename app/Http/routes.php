<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'departmentRedirect', 'localeSessionRedirect', 'localizationRedirect' ]
], function() {
    /** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/
    Route::get('/', ['uses' => 'HomeController@index']);

    Route::group(['prefix' => '{department}', 'as' => 'department::','middleware' => [ 'department', 'userFromDepartment' ]], function () {
        Route::get('/', ['as' => 'index', 'uses' => 'HomeController@department']);

        Route::group(['prefix' => 'auth', 'as' => 'auth::', 'middleware' => ['guest']], function () {
            /** Authentication routes **/
            Route::get('login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
            Route::post('login', ['as' => 'login', 'uses' => 'Auth\AuthController@postLogin']);

            /** Registration routes **/
            Route::get('register', ['as' => 'register', 'uses' => 'Auth\AuthController@getRegister']);
            Route::post('register', ['as' => 'register', 'uses' => 'Auth\AuthController@postRegister']);
        });

        Route::group(['as' => 'user::', 'middleware' => ['auth']], function () {
            Route::get('profile', ['as' => 'profile', 'uses' => 'UsersController@getProfile']);
            Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);

            Route::put('profile', ['as' => 'profile', 'uses' => 'UsersController@postProfile']);

        });


        Route::get('/test' , function(){
            \App\User::first()->categories()->attach(1);
        });
    });

    /** ---------- ADMIN ROUTES ---------- */
    Route::group(['prefix' => 'admin'], function () {
        Route::get('a', function () {
            return view('layouts.master', ['data' => 'No data']);
        });
    });
});

//Route::group(['prefix' => LaravelLocalization::setLocale() . '/{department}', 'as' => 'department::', 'middleware' => [ 'department' ]], function () {
//    Route::get('/', ['as' => 'index', 'uses' => 'HomeController@department']);
//
//});


/** OTHER PAGES THAT SHOULD NOT BE LOCALIZED **/