<?php
/**
 * SettingsController.php
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
 * @copyright  2017 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace App\Api\Controllers;

use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Settings;

/**
 * Settings resource representation.
 *
 * @Resource("Settings", uri="/api/settings")
 */
class SettingsController extends Controller
{
    use Helpers;

    /**
     * List all settings
     *
     * @Get("/")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request("/"),
     *      @Response(200, body={"multi":{"dimensional","json"},"array":"values"})
     * })
     */
    public function index()
    {
        return Settings::all();
    }

    /**
     * Save a setting or array of settings
     *
     * @Post("/{setting}")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"setting":"snmp.community", "value":{"public","private"}}),
     *      @Response(200)
     * })
     * @Parameters({
     *      @Parameter("setting", type="string", required=true, description="The setting path, separated by periods"),
     *      @Parameter("value", type="string", required=true, description="The value to set")
     * })
     */
    public function store(Request $request)
    {
        // TODO move to validation
        if (!$request->user()->isAdmin()) {
            return $this->response->errorForbidden('Only Admins can change settings');
        }

        Settings::set($request->setting, $request->value);
        return $this->response->accepted();
    }

    /**
     * Retrieve a setting
     *
     * @Get("/{setting}")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request("/snmp.community"),
     *      @Response(200, body={"public","private"})
     * })
     * @Parameters({
     *      @Parameter("setting", type="string", required=true, description="The setting path, separated by periods")
     * })
     */
    public function show($id)
    {
        return Settings::get($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!$request->user()->isAdmin()) {
            return $this->response->errorForbidden('Only Admins can change settings');
        }

        if (!isset($request->value)) {
            return $this->response->errorBadRequest('Missing value');
        }

        Settings::set($id, $request->value);
        return $this->response->accepted();
    }

    /**
     * Unset a setting
     *
     * @Delete("/{setting}")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request("/snmp.community"),
     *      @Response(200)
     * })
     * @Parameters({
     *      @Parameter("setting", type="string", required=true, description="The setting path, separated by periods")
     * })
     */
    public function destroy(Request $request, $id)
    {
        if (!$request->user()->isAdmin()) {
            return $this->response->errorForbidden('Only Admins can change settings');
        }

        Settings::forget($id);
        return $this->response->accepted();
    }
}
