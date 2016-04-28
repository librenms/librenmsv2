<?php
/**
 * app/Api/Controllers/General/ResourceController.php
 *
 * API Controller for resources such as IP, ARP, Mac, etc
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
 * @copyright  2016 Neil Lathwood
 * @author     Neil Lathwood <neil@lathwood.co.uk>
 */

namespace App\Api\Controllers\General;

use App\Api\Controllers\Controller;
use App\Models\General\IPv4;
use App\Models\General\IPv4Mac;
use App\Models\General\IPv6;
use App\Models\Port;
use Dingo\Api\Http;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class ResourceController extends Controller
{

    use Helpers;

    /**
     * Display a listing of all alerts
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->response->array(array('statusText' => 'OK', 'resources' => ['ipv4', 'ipv6', 'arp', 'mac']));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response|null
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|null
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param string $resource
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function show(Request $request, $resource)
    {
        $per_page = $request->per_page ?: 25;
        if ($resource === "ipv4")
        {
            return IPv4::paginate($per_page);
        }
        elseif ($resource === "ipv6")
        {
            return IPv6::paginate($per_page);
        }
        elseif ($resource === "mac")
        {
            return Port::select('port_id', 'ifPhysAddress')->paginate($per_page);
        }
        elseif ($resource === "arp")
        {
            return IPv4Mac::paginate($per_page);
        }
        else {
            return response()->json(['message' => "Resource $resource not found!"], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response|null
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response|null
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response|null
     */
    public function destroy($id)
    {
        //
    }

}
