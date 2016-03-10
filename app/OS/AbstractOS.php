<?php
namespace App\OS;

class AbstractOS {
    /**
     * Constructor
     */
    final public function __construct(\App\Device $device) {
        $this->device = $device;
    }

    /**
     * Get Magic Function
     * @param mixed $e Element to return
     * @return mixed
     */
    final public function __get($e) {
        if( isset($this->$e) ) {
            list($tmp) = explode(" ",$this->device->features);
            if( isset($this->derivates[$tmp][$e]) ) {
                return $this->derivates[$tmp][$e];
            }
            return $this->$e;
        }
        return NULL;
    }

    /**
     * Isset Magic Function
     * @param mixed $e Element to check
     * @return boolean
     */
    final public function __isset($e) {
        return isset($this->$e) ? true : false;
    }
}
