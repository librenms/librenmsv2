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
    // Authentication Routes...
    $this->get('login', 'Auth\AuthController@showLoginForm');
    $this->post('login', 'Auth\AuthController@login');
    $this->get('logout', 'Auth\AuthController@logout');

    // Password Reset Routes...
    $this->get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    $this->post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    $this->post('password/reset', 'Auth\PasswordController@reset');

    Route::get('/', 'HomeController@redirect')->name('home');
    Route::resource('dashboard', 'HomeController', ['parameters' => ['dashboard' => 'dashboard_id']]);
    Route::resource('widgets', 'WidgetsController');
    Route::resource('devices', 'DeviceController');
    Route::resource('ports', 'PortController', ['except' => ['create', 'store', 'destroy']]);
    Route::get('notifications/{type?}', 'NotificationController@index');
    Route::patch('notifications/{id}/{action}', 'NotificationController@update');
    Route::put('notifications', 'NotificationController@create');
    Route::get('about', 'HomeController@about');
    Route::match(['get', 'post'], '/preferences', 'UserController@preferences');
    Route::resource('settings', 'SettingsController');
});

// ---- API Routes ----

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function($api) {
    $api->post('auth', 'App\Api\Controllers\APIAuthController@authenticate');
    $api->group(['middleware' => 'api.auth', 'providers' => ['basic', 'jwt']], function($api) {
        $api->resource('devices', 'App\Api\Controllers\DeviceController');
        $api->resource('ports', 'App\Api\Controllers\PortController', ['except' => ['create', 'store', 'destroy']]);
        $api->get('notifications/{type?}', 'App\Api\Controllers\NotificationController@index');
        $api->patch('notifications/{id}/{action}', ['as' => 'api.notifications.update', 'uses' => 'App\Api\Controllers\NotificationController@update']);
        $api->put('notifications', ['as' => 'api.notifications.create', 'uses' => 'App\Api\Controllers\NotificationController@create']);
        $api->get('info', 'App\Api\Controllers\APIController@get_info');
        $api->get('stats', 'App\Api\Controllers\APIController@get_stats');
        $api->delete('dashboard/{dashboard_id}/clear', 'App\Api\Controllers\DashboardController@clear');
        $api->resource('dashboard', 'App\Api\Controllers\DashboardController', ['parameters' => ['dashboard' => 'dashboard_id']]);
        $api->resource('widget', 'App\Api\Controllers\WidgetController', ['paramaters' => ['widget' => 'widget_id']]);
        $api->resource('dashboard-widget', 'App\Api\Controllers\DashboardWidgetController', ['paramaters' => ['dashboard-widget' => 'user_widget_id']]);
        $api->get('dashboard-widget/{user_widget_id}/content', ['as' => 'api.dashboard-widget.get_content', 'uses' => 'App\Api\Controllers\DashboardWidgetController@get_content']);
        $api->get('dashboard-widget/{user_widget_id}/settings', ['as' => 'api.dashboard-widget.get_settings', 'uses' => 'App\Api\Controllers\DashboardWidgetController@get_settings']);
    });
});
