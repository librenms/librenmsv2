<?php
/**
 * web.php
 *
 * -Description-
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    LibreNMS
 * @link       http://librenms.org
 * @copyright  2016 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
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

// ---- Web Routes ----


Auth::routes();
//
//Route::group(['middleware' => 'auth'], function() {

//    Route::get('/', 'HomeController@redirect')->name('home');
//    Route::resource('dashboard', 'HomeController', ['parameters' => ['dashboard' => 'dashboard_id']]);
//    Route::get('/logout', 'Auth\LoginController@logout');
//});

// Unauthenticated Routes
//Route::group(['middleware' => 'web'], function() {
//    // Authentication Routes
//    Route::get('login', 'Auth\LoginController@showLoginForm');
//    Route::post('login', 'Auth\LoginController@login');
//    Route::get('logout', 'Auth\LoginController@logout');
//});

// Authenticated Routes
Route::group(['middleware' => 'auth'], function() {
    // Password Reset Routes...
//    Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
//    Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
//    Route::post('password/reset', 'Auth\PasswordController@reset');

    // Overview routes
//    Route::get('/', function()
//    {
//        return 'Hello World';
//    });
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
Route::group(['middleware' => 'admin'], function() {
    // User Management
    Route::resource('users', 'UserController');
    Route::resource('users.devices', 'UserDeviceController', ['only' => ['create', 'store', 'destroy']]);
    Route::resource('users.ports', 'UserPortController', ['only' => ['create', 'store', 'destroy']]);
});

