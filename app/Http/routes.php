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
    get('/', ['uses' => 'HomeController@index']);

    /** ---------- ADMIN ROUTES ---------- */
    Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
        get('/', ['as' => 'admin-index', 'uses' => '\App\Http\Controllers\HomeController@admin']);
        resource('departments', 'DepartmentController');
        resource('categories', 'CategoryController');
    });

    Route::group(['prefix' => '{department}', 'as' => 'department::', 'middleware' => [ 'department', 'userFromDepartment' ]], function () {
        get('/', ['as' => 'index', 'uses' => 'HomeController@department']);

        Route::group(['prefix' => 'auth', 'as' => 'auth::', 'middleware' => ['guest']], function () {
            /** Authentication routes **/
            get('login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
            post('login', ['as' => 'login', 'uses' => 'Auth\AuthController@postLogin']);

            /** Registration routes **/
            get('register', ['as' => 'register', 'uses' => 'Auth\AuthController@getRegister']);
            post('register', ['as' => 'register', 'uses' => 'Auth\AuthController@postRegister']);
        });

        Route::group(['as' => 'user::', 'middleware' => ['auth']], function () {
            get('profile', ['as' => 'profile', 'uses' => 'UsersController@getProfile']);
            put('profile', ['as' => 'profile', 'uses' => 'UsersController@postProfile']);
            get('change', ['as' => 'change', 'uses' => 'UsersController@getChangePassword']);
            put('change', ['as' => 'change', 'uses' => 'UsersController@postChangePassword']);

            get('logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);
        });
    });
});