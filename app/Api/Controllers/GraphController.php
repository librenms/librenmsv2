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

use Dingo\Api\Http;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

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
        $class = 'App\Graphs\\' . ucfirst($type);
        $input = json_decode($request->{'input'});
        $data=new $class();
        $data->setType($type);
        $data->setInput($input);
        $data->setDevice($input);
        return $data->json($request);
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
        $class = 'App\Graphs\\' . ucfirst($type);
        $input = json_decode($request->{'input'});
        $data=new $class();
        $data->setType($type);
        $data->setInput($input);
        $data->setDevice($input);
        return $data->png($request);
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
        $class = 'App\Graphs\\' . ucfirst($type);
        $input = json_decode($request->{'input'});
        $data=new $class();
        $data->setType($type);
        $data->setInput($input);
        $data->setDevice($input);
        return $data->csv($request);
    }

}
