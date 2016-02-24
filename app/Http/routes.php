<?php

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

Route::group(['middleware' => ['web']], function () {
    Route::auth();
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index');
    Route::resource('devices', 'DeviceController');
});

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
    $api->post('auth',  'App\Api\Controllers\APIAuthController@authenticate');
    $api->group(['middleware' => 'api.auth'], function ($api) {
        $api->get('devices', 'App\Api\Controllers\APIController@list_devices');
    });
});
