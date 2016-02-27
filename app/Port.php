<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Port extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ports';

    /**
     * The primary key column name.
     *
     * @var string
     */
    protected $primaryKey = 'port_id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    // TODO: transform DB to be snake case?
//    public static $snakeAttributes = false;

    // ---- Accessors/Mutators ----

    //TODO this is the wrong place for this as it messes up sorting
//    public function getifSpeedAttribute($ifSpeed) {
//        return $this->getifSpeedHumanAttribute($ifSpeed);
//    }

    public function getifSpeedHumanAttribute($ifSpeed) {
        return $this->formatBps($ifSpeed);
    }


    // TODO: move to a common file
    // base = 1024 for bits, 1000 for mibibits
    function formatBps($bits, $precision = 2, $base = 1000) {
        $units = array('bps', 'Kbps', 'Mbps', 'Gbps', 'Tbps');

        $bits = max($bits, 0);
        $pow = floor(($bits ? log($bits) : 0) / log($base));
        $pow = min($pow, count($units) - 1);

        $bits /= pow($base, $pow);

        return round($bits, $precision).' '.$units[$pow];
    }


    // ---- Define Reletionships ----

    /**
     * Get the device this port belongs to.
     *
     */
    public function device() {
        return $this->belongsTo('App\Device', 'device_id', 'device_id');
    }

    /**
     * Returns a list of users that can access this port.
     */
    public function users() {
        return $this->belongsToMany('App\User', 'ports_perms', 'port_id', 'user_id');
    }

}
