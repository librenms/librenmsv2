<?php

use Dingo\Api\Routing\Router;

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

ApiRoute::version('v1', function (Router $api) {
    $api->post('auth', 'App\Api\Controllers\APIAuthController@authenticate');

    $api->group(['middleware' => 'api.auth', 'providers' => ['basic', 'jwt']], function (Router $api) {
        $api->resource('devices', 'App\Api\Controllers\DeviceController');
        $api->resource('ports', 'App\Api\Controllers\PortController', ['except' => ['create', 'store', 'destroy']]);
        $api->get('notifications/{type?}', 'App\Api\Controllers\NotificationController@index');
        $api->patch('notifications/{id}/{action}', ['as' => 'api.notifications.update', 'uses' => 'App\Api\Controllers\NotificationController@update']);
        $api->put('notifications', ['as' => 'api.notifications.create', 'uses' => 'App\Api\Controllers\NotificationController@create']);
        $api->get('info', 'App\Api\Controllers\APIController@getInfo');
        $api->get('stats', 'App\Api\Controllers\APIController@getStats');

        // Overview section
        $api->delete('dashboard/{dashboard_id}/clear', 'App\Api\Controllers\DashboardController@clear');
        $api->resource('dashboard', 'App\Api\Controllers\DashboardController', ['parameters' => ['dashboard' => 'dashboard_id']]);
        $api->resource('widget', 'App\Api\Controllers\WidgetController', ['paramaters' => ['widget' => 'widget_id']]);
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

        //Graphing section
        $api->post('graph-data/{type}/png', 'App\Api\Controllers\GraphController@png');
        $api->post('graph-data/{type}/json', 'App\Api\Controllers\GraphController@json');
        $api->post('graph-data/{type}/csv', 'App\Api\Controllers\GraphController@csv');
    });
});
