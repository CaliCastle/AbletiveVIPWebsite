<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'web'], function () {
    Route::auth();
});

Route::group(['middleware' => ['web', 'auth', 'membership.valid']], function () {
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index');
    Route::get('/refresh', 'HomeController@refresh');
    Route::get('/projects', 'ProjectController@showProjects');
    Route::get('/projects/search/{keyword}', 'ProjectController@searchProjects');
    Route::get('/projects/starred', 'ProjectController@showStarred');
    Route::post('/projects/star/{project}', 'ProjectController@postStar');
});

Route::group(['middleware' => ['web', 'auth', 'manager']], function () {
    Route::get('/manage', 'ManageController@index');
    Route::get('/manage/projects', 'ManageController@projects');
    Route::get('/manage/projects/add', 'ManageController@createProject');
    Route::post('/manage/projects/add', 'ManageController@addProject');
    Route::get('/manage/projects/search/{keyword}', 'ManageController@searchProjects');
    Route::get('/manage/project/{project}', "ManageController@editProject");
    Route::post('/manage/project/{project}', 'ManageController@saveProject');
    Route::delete('/manage/project/{project}', 'ManageController@deleteProject');
    Route::get('/manage/users', 'ManageController@users');
    Route::get('/manage/users/search/{keyword}', 'ManageController@searchUsers');
    Route::post('/manage/user/promote/{user}', 'ManageController@promoteUser');
    Route::delete('/manage/user/{user}', 'ManageController@deleteUser');
});