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

// Unauthenticated Routes
Route::group(['middleware' => 'web'], function() {
    // Authentication Routes
    Route::get('login', 'Auth\AuthController@showLoginForm');
    Route::post('login', 'Auth\AuthController@login');
    Route::get('logout', 'Auth\AuthController@logout');
});

// Authenticated Routes
Route::group(['middleware' => 'auth'], function() {
    // Password Reset Routes...
    Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\PasswordController@reset');

    // Overview routes
    Route::get('/', 'HomeController@redirect')->name('home');
    Route::resource('dashboard', 'HomeController', ['parameters' => ['dashboard' => 'dashboard_id']]);
    Route::resource('eventlog', 'General\EventlogController');
    Route::resource('syslog', 'General\SyslogController');
    Route::resource('inventory', 'General\InventoryController');
    Route::resource('widgets', 'WidgetsController');
    Route::resource('rirtools', 'General\RIRController');
    Route::get('search/ipv4', 'General\SearchController@ipv4');
    Route::get('search/ipv6', 'General\SearchController@ipv6');
    Route::get('search/mac', 'General\SearchController@mac');
    Route::get('search/arp', 'General\SearchController@arp');

    // Device routes
    Route::get('devices/group={group_id}', 'DeviceController@index');
    Route::resource('devices', 'DeviceController');

    // Port routes
    Route::resource('ports', 'PortController', ['except' => ['create', 'store', 'destroy']]);
    Route::get('notifications/{type?}', 'NotificationController@index');
    Route::patch('notifications/{id}/{action}', 'NotificationController@update');
    Route::put('notifications', 'NotificationController@create');
    Route::get('about', 'HomeController@about');

    // Settings
    Route::resource('settings', 'SettingsController');

    //User Preferences
    Route::get('preferences', 'UserController@preferences');

    //Alerting section
    Route::resource('alerting/alerts', 'Alerting\AlertsController');
    Route::resource('alerting/logs', 'Alerting\LogsController');
    Route::resource('alerting/stats', 'Alerting\StatsController');

    // Load widgets
    Route::get('widget-data/availability-map/{action?}', 'Widgets\WidgetDataController@availabilitymap');
    Route::get('widget-data/alerts/{action?}', 'Widgets\WidgetDataController@alerts');
    Route::get('widget-data/device-summary-horiz/{action?}', ['uses' => 'Widgets\WidgetDataController@devicesummary', 'type' => 'horiz']);
    Route::get('widget-data/device-summary-vert/{action?}', ['uses' => 'Widgets\WidgetDataController@devicesummary', 'type' => 'vert']);
    Route::get('widget-data/eventlog/{action?}', 'Widgets\WidgetDataController@eventlog');
    Route::get('widget-data/notes/{action?}', 'Widgets\WidgetDataController@notes');
    Route::get('widget-data/syslog/{action?}', 'Widgets\WidgetDataController@syslog');
    Route::get('widget-data/worldmap/{action?}', 'Widgets\WidgetDataController@worldmap');
});

// Admin Only routes
Route::group(['middleware' => 'admin'], function() {
    // User Management
    Route::resource('users', 'UserController');
    Route::resource('users.devices', 'UserDeviceController', ['only' => ['create', 'store', 'destroy']]);
    Route::resource('users.ports', 'UserPortController', ['only' => ['create', 'store', 'destroy']]);
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

        // Overview section
        $api->delete('dashboard/{dashboard_id}/clear', 'App\Api\Controllers\DashboardController@clear');
        $api->resource('dashboard', 'App\Api\Controllers\DashboardController', ['parameters' => ['dashboard' => 'dashboard_id']]);
        $api->resource('widget', 'App\Api\Controllers\WidgetController', ['paramaters' => ['widget' => 'widget_id']]);
        $api->resource('dashboard-widget', 'App\Api\Controllers\DashboardWidgetController', ['paramaters' => ['dashboard-widget' => 'user_widget_id']]);
        $api->resource('eventlog', 'App\Api\Controllers\General\EventlogController');
        $api->resource('syslog', 'App\Api\Controllers\General\SyslogController');
        $api->resource('inventory', 'App\Api\Controllers\General\InventoryController');
        $api->get('search/ipv4', 'App\Api\Controllers\General\SearchController@ipv4');
        $api->get('search/ipv6', 'App\Api\Controllers\General\SearchController@ipv6');
        $api->get('search/mac', 'App\Api\Controllers\General\SearchController@mac');
        $api->get('search/arp', 'App\Api\Controllers\General\SearchController@arp');

        //Alerting section
        $api->resource('alerting/alerts', 'App\Api\Controllers\Alerting\AlertsController');
        $api->resource('alerting/logs', 'App\Api\Controllers\Alerting\LogsController');
    });
});
