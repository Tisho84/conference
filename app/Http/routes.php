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

    Route::group(['prefix' => '{department}', 'middleware' => [ 'department' ]], function () {
        Route::get('/', ['as' => 'department', 'uses' => 'HomeController@department']);

    });

    /** ---------- ADMIN ROUTES ---------- */
    Route::group(['prefix' => 'admin'], function () {
        Route::get('a', function () {
            return view('layouts.master', ['data' => 'No data']);
        });
    });
});

/** OTHER PAGES THAT SHOULD NOT BE LOCALIZED **/