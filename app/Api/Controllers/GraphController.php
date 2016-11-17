<?php
/**
 * app/Api/Controllers/GraphController.php
 *
 * API Controller for alerts log data
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

namespace App\Api\Controllers;

use App\Graphs\BaseGraph;
use App\Models\Device;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class GraphController extends Controller
{

    use Helpers;

    /**
     * Obtain and format data for json output
     *
     * @param Request $request
     * @param string $type
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function json(Request $request, $type)
    {
        ob_start('ob_gzhandler');
        $data = $this->initializeData($request, $type);
        return $data->json();
    }

    /**
     * Obtain and format data for png output
     *
     * @param Request $request
     * @param string $type
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function png(Request $request, $type)
    {
        $data = $this->initializeData($request, $type);
        return $data->png();
    }

    /**
     * Obtain and format data for csv output
     *
     * @param Request $request
     * @param string $type
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function csv(Request $request, $type)
    {
        ob_start('ob_gzhandler');
        $data = $this->initializeData($request, $type);
        return $data->csv();
    }

    /**
     * Common initialization
     *
     * @param Request $request
     * @param string $type
     * @return BaseGraph
     * @throws \Exception
     */
    private function initializeData(Request $request, $type)
    {
        $class = 'App\Graphs\\'.ucfirst($type);
        if (!class_exists($class)) {
            throw new \Exception("Graph type $type ($class) not found");
        }

        $input = json_decode($request->{'input'});
        $device = Device::find($input->device_id);
        /** @var BaseGraph $data */
        $data = new $class($device, $type, $request, $input);
        return $data;
    }
}
