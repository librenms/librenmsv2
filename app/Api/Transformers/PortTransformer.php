<?php
namespace App\Api\Transformers;

use App\Port;
use League\Fractal;

class PortTransformer extends Fractal\TransformerAbstract
{
    public function transform(Port $port)
    {
        return [
            'id'                        => (int) $port->port_id,
            'device_id'                  => (int) $port->device_id,
            'device_name'               => $port->device->hostname,
            'alias'                     => $port->ifAlias,
            'speed'                     => (int) $port->ifSpeed,
            'out_unicast_pkts_delta'    => (int) $port->ifOutUcastPkts_delta,
            'in_unicast_pkts_delta'     => (int) $port->ifInUcastPkts_delta,
            'type'                      => $port->ifType,
            'description'               => $port->ifDescr,
        ];
    }
}
