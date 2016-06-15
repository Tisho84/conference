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
    Route::group(['prefix' => 'api'], function(){
        get('categories', ['as' => 'department_categories', 'uses' => 'APIController@categories']);
        get('reviewers', ['as' => 'category_reviewers', 'uses' => 'APIController@reviewers']);
        get('authors', ['as' => 'department_authors', 'uses' => 'APIController@authors']);
        get('filter', ['as' => 'department_filter', 'uses' => 'APIController@filter']);
        get('templates', ['as' => 'department_templates', 'uses' => 'APIController@templates']);
        get('users', ['as' => 'department_users', 'uses' => 'APIController@users']);
    });
    /** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/
    get('/', ['as' => 'home-index', 'uses' => 'HomeController@index']);
    /** ---------- ADMIN ROUTES ---------- */
    get('/admin/', ['as' => 'admin-index', 'uses' => 'HomeController@getLogin']);
    post('/admin', ['uses' => 'HomeController@postLogin']);
    get('logout', ['as' => 'logout', 'uses' => 'HomeController@logout']);
    Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['admin']], function () {
        get('/home', ['as' => 'admin-home', 'uses' => '\App\Http\Controllers\HomeController@admin']);
        resource('departments', 'DepartmentController');
        resource('users', 'UsersController');
        get('users/{user_id}/papers/{paper_id}', 'UsersController@paper');
        resource('news', 'NewsController');
        resource('types', 'UserTypesController');
        resource('categories', 'CategoryController');
        resource('papers', 'PaperController');
        resource('archive', 'ArchiveController');
        get('archive/{archive}/papers/{paper}', 'ArchiveController@showPapers');
        get('papers/{id}/evaluate', 'PaperController@getEvaluate');
        post('papers/{id}/evaluate', 'PaperController@postEvaluate');
        resource('criteria', 'CriteriaController');
        resource('criteria.options', 'CriteriaOptionController');
        get('settings', 'SettingsController@display');
        post('settings', 'SettingsController@save');
        post('settings/auto', 'SettingsController@auto');
        resource('templates', 'EmailTemplateController');
        get('email', 'EmailTemplateController@getEmail');
        post('email', 'EmailTemplateController@postEmail');
    });

    Route::group(['prefix' => '{department}', 'as' => 'department::', 'middleware' => ['department', 'userFromDepartment']], function () {
        get('/', 'HomeController@news');
        get('/news', ['as' => 'index', 'uses' => 'HomeController@news']);

        Route::group(['prefix' => 'auth', 'as' => 'auth::', 'middleware' => ['guest']], function () {
            /** Authentication routes **/
            get('login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
            post('login', ['as' => 'login', 'uses' => 'Auth\AuthController@postLogin']);

            /** Registration routes **/
            get('register', ['as' => 'register', 'uses' => 'Auth\AuthController@getRegister']);
            post('register', ['as' => 'register', 'uses' => 'Auth\AuthController@postRegister']);

            Route::get('password/email', ['as' => 'reset_pass', 'uses' => 'Auth\PasswordController@getEmail']);
            Route::post('password/email', 'Auth\PasswordController@postEmail');

            // Password reset routes...
            Route::get('password/reset/{token}', ['as' => 'reset_token', 'uses' => 'Auth\PasswordController@getReset']);
            Route::post('password/reset', 'Auth\PasswordController@postReset');
        });

        Route::group(['as' => 'user::', 'middleware' => ['auth']], function () {
            get('profile', ['as' => 'profile', 'uses' => 'UsersController@getProfile']);
            put('profile', ['as' => 'profile', 'uses' => 'UsersController@postProfile']);
            get('change', ['as' => 'change', 'uses' => 'UsersController@getChangePassword']);
            put('change', ['as' => 'change', 'uses' => 'UsersController@postChangePassword']);
            /** Papers routes **/
            resource('papers', 'PaperController');
            get('papers/{id}/invoice', ['as' => 'invoice', 'uses' => 'PaperController@getInvoice']);
            post('papers/{id}/invoice', ['as' => 'invoice', 'uses' => 'PaperController@postInvoice']);
            post('papers/{id}', 'PaperController@request');

            get('papers/{id}/evaluate', ['as' => 'evaluate', 'uses' => 'PaperController@getEvaluate']);
            post('papers/{id}/evaluate', ['as' => 'evaluate', 'uses' => 'PaperController@postEvaluate']);

            get('logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);
        });
    });
});