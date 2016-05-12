<?php
/**
 * UserPortController.php
 *
 * Controls the user port relationship
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

namespace App\Http\Controllers;

use App\Http\Requests\AdminOnlyRequest;
use App\Models\Port;
use App\Models\User;

class UserPortController extends Controller
{
    /**
     * @param AdminOnlyRequest $request
     * @param $user_id
     * @return mixed
     */
    public function create(AdminOnlyRequest $request, $user_id)
    {
        $user = User::with('ports')->find($user_id);
        return view('users.ports-create')->withUser($user);
    }

    /**
     * @param AdminOnlyRequest $request
     * @param $user_id
     * @param $port_id
     * @return mixed
     */
    public function store(AdminOnlyRequest $request, $user_id)
    {
        $user = User::find($user_id);

        $port_ids = $request->input('ports');

        if (!is_array($port_ids) || count($port_ids) == 0) {
            return redirect()->back();
        }

        foreach ($port_ids as $port_id) {
            $port = Port::find($port_id);
            $user->ports()->attach($port);
        }
        return redirect()->back()->with(['type' => 'success', 'message' => trans('user.text.portsadded')]);
    }

    /**
     * @param AdminOnlyRequest $request
     * @param $user_id
     * @param $port_id
     * @return mixed
     */
    public function destroy(AdminOnlyRequest $request, $user_id, $port_id)
    {
        $user = User::find($user_id);
        $port = Port::find($port_id);
        $user->ports()->detach($port);
        return redirect()->back()->with(['type' => 'success', 'message' => trans('user.text.portremoved', ['label' => $port->getLabel()])]);
    }

}
