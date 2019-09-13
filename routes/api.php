<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::namespace('Api')->group(function () {
    //user registration
    Route::post('/register', 'AuthController@register');

    //user login
    Route::post('/login', 'AuthController@login');

    //Task assign
    Route::post('/task', 'TaskController@saveTask');

    //Task update
    Route::put('/task/{task_id}', 'TaskController@updateTask');

    Route::get('/task/list', 'TaskController@showTaskList');


});
