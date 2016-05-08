<?php
/**
 * app/Http/Controllers/Widgets/WidgetDataController.php
 *
 * HTTP Controller for Widgets data
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

namespace App\Http\Controllers\Widgets;

use App\DataTables\Alerting\AlertsDataTable;
use App\DataTables\General\EventlogDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WidgetDataController extends Controller
{
    /**
     * Display the eventlog widget.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function eventlog(EventlogDataTable $dataTable)
    {
        return $dataTable->render('general.widget');
    }


    /**
     * Display the alerts widget.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function alerts(AlertsDataTable $dataTable)
    {
        return $dataTable->render('general.widget');
    }

    /**
     * Display the availability-map widget.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response|null
     */
    public function availability_map()
    {
        return view('widgets.availability-map');
    }

}
