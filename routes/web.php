<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

// Authenticated Routes
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@redirect')->name('home');
    Route::resource('dashboard', 'HomeController', ['parameters' => ['dashboard' => 'dashboard_id']]);
    Route::resource('eventlog', 'General\EventlogController');
    Route::resource('syslog', 'General\SyslogController');
    Route::resource('inventory', 'General\InventoryController');
//    Route::resource('widgets', 'WidgetsController');
    Route::resource('rirtools', 'General\RIRController');
    Route::get('search/ipv4', 'General\SearchController@ipv4');
    Route::get('search/ipv6', 'General\SearchController@ipv6');
    Route::get('search/mac', 'General\SearchController@mac');
    Route::get('search/arp', 'General\SearchController@arp');

    // Device routes
    Route::get('devices/group={group_id}', 'DeviceController@index');
    Route::resource('devices', 'DeviceController');
    Route::get('devices/{id}/{page}', 'DeviceController@show');

    // Device Groups
    Route::resource('device-groups', 'DeviceGroupController');

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
    Route::get('widget-data/generic-graph/{action?}', 'Widgets\WidgetDataController@graph');
    Route::get('widget-data/notes/{action?}', 'Widgets\WidgetDataController@notes');
    Route::get('widget-data/syslog/{action?}', 'Widgets\WidgetDataController@syslog');
    Route::get('widget-data/worldmap/{action?}', 'Widgets\WidgetDataController@worldmap');
});

// Admin Only routes
Route::group(['middleware' => 'admin'], function () {
    // User Management
    Route::resource('users', 'UserController');
    Route::resource('users.devices', 'UserDeviceController', ['only' => ['create', 'store', 'destroy']]);
    Route::resource('users.ports', 'UserPortController', ['only' => ['create', 'store', 'destroy']]);
});
