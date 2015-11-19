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
    get('/login', ['as' => 'show_login', function () {
        return view('login');
    }]);

    post('/login', ['as' => 'post_login', 'uses' => 'AuthController@authenticate']);
});

Route::group(['middleware' => 'auth'], function () {
    get('/', ['as' => 'profile', 'uses' => 'AuthController@show']);
    get('/admin', ['as' => 'admin', 'uses' => 'AuthController@admin']);

    post('/grade', ['as' => 'add_grade', 'uses' => 'GradeController@store']);

    post('/project', ['as' => 'add_project', 'uses' => 'ProjectController@store']);
    delete('/project', ['as' => 'delete_project', 'uses' => 'ProjectController@delete']);
    get('/project/{id}', ['as' => 'download_project', 'uses' => 'ProjectController@download']);

    get('logout', ['as' => 'logout', function () {
        Auth::logout();
        return redirect()->route('show_login');
    }]);
});