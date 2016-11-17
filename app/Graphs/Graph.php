<?php
/**
 * BaseGraph.php
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

namespace App\Graphs;

use App\Data\RRDGraph;
use App\Data\RRDXport;
use App\Exceptions\UnknownDataSourceException;
use App\Models\Device;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use stdClass;

abstract class Graph
{
    protected $device;
    protected $type;
    protected $request;
    protected $input;
    protected $headers = [];

    /**
     * BaseGraph constructor.
     *
     * @param string $type
     * @param Request $request
     * @param stdClass $input
     */
    public function __construct($type, Request $request, $input = null)
    {
        $this->type = $type;
        $this->request = $request;
        if (is_null($input)) {
            $this->input = json_decode($request->{'input'});
        } else {
            $this->input = $input;
        }
        $this->device = $this->fetchDevice();
    }

    /**
     * Get the data for this graph in the requested format
     *
     * @param string $format png, json, or rrd
     * @return string
     * @throws UnknownDataSourceException
     */
    public function getGraph($format)
    {
        $sourceName = $this->request->source;
        $source = null;
        if ($sourceName === 'rrd') {
            if ($format == 'png') {
                $source = $this->createRRDGraph();
            } else {
                $source = $this->createRRDXport();
            }
        } else {
            throw new UnknownDataSourceException("Source type $source is not supported");
        }

        return $source->fetch($format);
    }

    /**
     * @return RRDXport
     */
    protected function createRRDXport()
    {
        return new RRDXport(
            $this->getRRDXportDefinition(),
            $this->getHeaders(),
            $this->input->start,
            $this->input->end
        );
    }

    /**
     * @return RRDGraph
     */
    protected function createRRDGraph()
    {
        return new RRDGraph(
            $this->getRRDGraphDefinition(),
            $this->input->start,
            $this->input->end,
            $this->input->width,
            $this->input->height
        );
    }

    /**
     * Check if there are request specific IDs
     *
     * @return bool
     */
    protected function hasIDs()
    {
        return isset($this->input->id) && (is_numeric($this->input->id) || str_contains($this->input->id, ','));
    }

    /**
     * Get the requested ID(s)
     *
     * @return array
     */
    protected function getIDs()
    {
        return explode(',', $this->input->id);
    }

    /**
     * Fetch the device with data
     * We use eager loading so we can load both at once
     *
     * @return mixed
     */
    protected function fetchDevice()
    {
        if ($this->hasIDs()) {
            $ids = explode(',', $this->input->id);
            return Device::with($this->getRelation())->findMany($ids);
        }

        return Device::with($this->getRelation())->find($this->input->device_id);
    }

    /**
     * Get the class name of a graph type for a give string
     *
     * @param string $graph_type This will be in the format 'device_ucd_memory'
     * @return string
     * @throws \Exception
     */
    public static function getClass($graph_type)
    {
        $name = ucwords(str_replace('_', '\\', $graph_type), '\\');
        $class = 'App\Graphs\\'.$name;
        if (class_exists($class)) {
            return $class;
        }
        throw new \Exception("Graph type $graph_type ($class) not found");
    }


    // -- Overrride these methods --

    /**
     * Returns the name(s) of the relationships to load for this graph
     * This may also be an associative array with a closure that accepts a query object
     * If you do not want to load any relationships, pass an empty array
     *
     * @return string|array
     */
    protected function getRelation()
    {
        return [];
    }


    /**
     * Get a Collection of db data for this graph
     * This is a helper function to the correct data related to Device
     *
     * @return Collection
     */
    protected function getData()
    {
        return new Collection();
    }

    /**
     * Get the chart headers for this graph
     * One string for each data set
     *
     * @return array
     */
    abstract protected function getHeaders();

    /**
     * Return the RRD definition string for Xport
     *
     * @return string
     */
    abstract protected function getRRDXportDefinition();

    /**
     * Return the RRD definition string for Graph creation
     *
     * @return string
     */
    abstract protected function getRRDGraphDefinition();
}
