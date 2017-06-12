<?php
namespace App\Api\Transformers;

use App\Models\Device;
use League\Fractal;

class DeviceTransformer extends Fractal\TransformerAbstract
{

    /**
     * Turn this item object into a generic array
     *
     * @param Device $device
     * @return array
     */
    public function transform(Device $device)
    {
        return [
            'device_id' => (int)$device->device_id,
            'hostname'  => $device->hostname,
            'os'        => $device->os,
            'icon'      => $device->icon,
            'status'    => (int)$device->status,
            'uptime'    => (int)$device->uptime,
        ];
    }
}
