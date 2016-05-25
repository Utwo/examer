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
Route::group(['middleware' => 'guest'], function () {
    Route::get('login', ['as' => 'show_login', 'uses' => 'HomeController@show_login']);
    Route::get('ubb-login', ['as' => 'login', 'uses' => 'AuthController@redirectToProvider']);
    Route::get('login_callback', ['as' => 'login', 'uses' => 'AuthController@handleProviderCallback']);
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', ['as' => 'profile', 'uses' => 'HomeController@show']);

    Route::post('/grade', ['as' => 'add_grade', 'uses' => 'GradeController@store']);

    Route::post('/project', ['as' => 'add_project', 'uses' => 'ProjectController@store']);
    Route::delete('/project', ['as' => 'delete_project', 'uses' => 'ProjectController@delete']);
    Route::get('/project/{id}', ['as' => 'download_project', 'uses' => 'ProjectController@download']);

    Route::get('logout', ['as' => 'logout', 'uses' => 'HomeController@logout']);

    Route::group(['middleware' => 'role:teacher'], function () {
        Route::get('/admin', ['as' => 'admin', 'uses' => 'HomeController@admin']);
        Route::get('/admin/subject', ['as' => 'get_subject', 'uses' => 'SubjectController@index']);
        Route::put('/subject', ['as' => 'update_subject', 'uses' => 'SubjectController@update']);
    });
});