<?php

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

// private routes
Route::middleware('auth:api')->group(function () {
    Route::get('/user', 'Auth\UserController@index');
    Route::post('/check_password', 'Auth\UserController@check_password');
    Route::put('/user/{user}', 'Auth\UserController@update');
    Route::get('/user/uniqueNo', 'Auth\UserController@get_user_no');
    //users
    Route::get('/users', 'Api\UsersController@index');
    Route::post('/users', 'Api\UsersController@store');
    Route::post('/users/show', 'Api\UsersController@show');
    Route::resource('/clients', 'Api\ClientController');
    Route::resource('/hospitals', 'Api\HospitalController');
    //patients
    Route::get('/patients', 'Api\PatientController@index');
    Route::post('/patients', 'Api\PatientController@store');
    // customize_settings
    Route::get('/customize_settings', 'Api\CustomizeSettingController@index');
    Route::post('/customize_settings', 'Api\CustomizeSettingController@store');
    Route::get('/customize_settings/{setting}', 'Api\CustomizeSettingController@show');

    Route::post('/delpatients', 'Api\PatientController@massDestroy');
    Route::resource('/departments', 'Api\DepController');
    Route::resource('/queues', 'Api\QueueController');
    Route::resource('/groups', 'Api\GroupController');
    //positions
    Route::resource('/positions', 'Api\PositionController');
    Route::resource('/ids', 'Api\IdsController');
    //permission groups
    Route::get('/perm-groups', 'Api\PermGroupController@index');
    Route::get('/perm-groups/{perm}', 'Api\PermGroupController@show');
    Route::post('/perm-groups', 'Api\PermGroupController@store');
    Route::put('/perm-groups/{perm}', 'Api\PermGroupController@update');
    Route::delete('/perm-groups/{perm}', 'Api\PermGroupController@destroy');
    // hospital branches
    Route::post('/branches', 'Api\HospBranchController@index');
    Route::get('/branches/{branch}', 'Api\HospBranchController@show');
    //modules
    Route::resource('/modules', 'Api\ModuleController');
    //room status
    Route::get('/room_status', 'Api\RoomStatusController@index');
    Route::post('/room_status', 'Api\RoomStatusController@store');
    Route::put('/room_status/{room}', 'Api\RoomStatusController@update');
    Route::get('/room_status/login', 'Api\RoomStatusController@login');
    Route::get('/room_status/logout', 'Api\RoomStatusController@logout');
});

// public routes
Route::post('/login', 'Auth\LoginController@index');
Route::post('/hospcode', 'Api\HospitalController@find');
