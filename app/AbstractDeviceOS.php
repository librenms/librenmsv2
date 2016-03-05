namespace App;

class AbstractDeviceOS {

    /**
     * Get Magic Function
     * @param mixed $e Element to return
     * @return mixed
     */
    function __get($e) {
        if( isset($this->$e) ) {
            return $this->$e
        }
        return NULL;
    }

    /**
     * Isset Magic Function
     * @param mixed $e Element to check
     * @return boolean
     */
    function __isset($e) {
        return isset($this->$e) ? true : false;
    }
}
