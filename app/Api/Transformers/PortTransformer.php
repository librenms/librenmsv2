<?php
namespace App\Api\Transformers;

use App\Models\Port;
use League\Fractal;

class PortTransformer extends Fractal\TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = ['device'];

    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Port $port)
    {
        return [
            'id'                        => (int) $port->port_id,
            'alias'                     => $port->ifAlias,
            'speed'                     => (int) $port->ifSpeed,
            'out_unicast_pkts_delta'    => (int) $port->ifOutUcastPkts_delta,
            'in_unicast_pkts_delta'     => (int) $port->ifInUcastPkts_delta,
            'type'                      => $port->ifType,
            'description'               => $port->ifDescr,
        ];
    }

    /**
     * Include Device
     *
     * @return Fractal\Resource\Item
     */
    public function includeDevice(Port $port)
    {
        $device = $port->device;
        return $this->item($device, new DeviceTransformer);
    }
}
