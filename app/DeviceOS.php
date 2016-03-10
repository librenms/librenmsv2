<?php
namespace App;

class DeviceOS {

    /**
     * Load OS Class
     * @param string $os Operating System Identifier
     * @return DeviceOS
     */
    static public function load(Device $device) {
        $class = 'App\\OS\\'.ucfirst(strtolower($device->os));
        if( class_exists($class) ) {
            return new $class($device);
        }
        return false; //FIXME: Raise Exception
    }
}
