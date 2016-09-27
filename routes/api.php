<?php
/**
 * api.php
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

//use \ApiRoute;
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

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:api');
//

//ApiRoute::post('auth', 'App\Api\Controllers\APIAuthController@authenticate');
//
//$api = app('Dingo\Api\Routing\Router');
//$api->version('v1', function($api) {
//    $api->post('auth', 'App\Api\Controllers\APIAuthController@authenticate');
//    $api->group(['middleware' => 'api.auth', 'providers' => ['basic', 'jwt']], function($api) {
//        $api->resource('devices', 'App\Api\Controllers\DeviceController');
//        $api->resource('ports', 'App\Api\Controllers\PortController', ['except' => ['create', 'store', 'destroy']]);
//        $api->get('notifications/{type?}', 'App\Api\Controllers\NotificationController@index');
//        $api->patch('notifications/{id}/{action}', ['as' => 'api.notifications.update', 'uses' => 'App\Api\Controllers\NotificationController@update']);
//        $api->put('notifications', ['as' => 'api.notifications.create', 'uses' => 'App\Api\Controllers\NotificationController@create']);
//        $api->get('info', 'App\Api\Controllers\APIController@get_info');
//        $api->get('stats', 'App\Api\Controllers\APIController@get_stats');
//
//        // Overview section
//        $api->delete('dashboard/{dashboard_id}/clear', 'App\Api\Controllers\DashboardController@clear');
//        $api->resource('dashboard', 'App\Api\Controllers\DashboardController', ['parameters' => ['dashboard' => 'dashboard_id']]);
//        $api->resource('widget', 'App\Api\Controllers\WidgetController', ['paramaters' => ['widget' => 'widget_id']]);
//        $api->resource('dashboard-widget', 'App\Api\Controllers\DashboardWidgetController', ['paramaters' => ['dashboard-widget' => 'user_widget_id']]);
//        $api->resource('eventlog', 'App\Api\Controllers\General\EventlogController');
//        $api->resource('syslog', 'App\Api\Controllers\General\SyslogController');
//        $api->resource('inventory', 'App\Api\Controllers\General\InventoryController');
//        $api->get('search/ipv4', 'App\Api\Controllers\General\SearchController@ipv4');
//        $api->get('search/ipv6', 'App\Api\Controllers\General\SearchController@ipv6');
//        $api->get('search/mac', 'App\Api\Controllers\General\SearchController@mac');
//        $api->get('search/arp', 'App\Api\Controllers\General\SearchController@arp');
//
//        //Alerting section
//        $api->resource('alerting/alerts', 'App\Api\Controllers\Alerting\AlertsController');
//        $api->resource('alerting/logs', 'App\Api\Controllers\Alerting\LogsController');
//    });
//});
