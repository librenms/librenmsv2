<?php
namespace App\Api\Transformers;

use App\Device;
use League\Fractal;

class DeviceTransformer extends Fractal\TransformerAbstract
{

    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Device $device)
    {
        return [
            'id'                        => (int) $device->device_id,
            'name'                      => $device->hostname,
            'icon'                      => $device->icon,
            'os'                        => $device->os,
            'status'                    => (int) $device->status,
        ];
    }
}
