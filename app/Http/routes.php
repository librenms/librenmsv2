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

// ---- Web Routes ----

Route::group(['middleware' => ['web']], function() {
    Route::auth();
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index');
    Route::resource('devices', 'DeviceController');
    Route::resource('ports', 'PortController', ['except' => ['create', 'store', 'destroy']]);
    Route::get('/about', 'HomeController@about');
});

// ---- API Routes ----

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function($api) {
    $api->post('auth', 'App\Api\Controllers\APIAuthController@authenticate');
    $api->group(['middleware' => 'api.auth'], function($api) {
        $api->resource('devices', 'App\Api\Controllers\DeviceController');
        $api->resource('ports', 'App\Api\Controllers\PortController', ['except' => ['create', 'store', 'destroy']]);
        $api->get('info', 'App\Api\Controllers\APIController@get_info');
    });
});
