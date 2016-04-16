<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Eventlog
 *
 * @property integer $device_id
 * @property string $hostname
 * @property string $sysName
 * @property mixed $ip
 * @property string $community
 * @property string $authlevel
 * @property string $authname
 * @property string $authpass
 * @property string $authalgo
 * @property string $cryptopass
 * @property string $cryptoalgo
 * @property string $snmpver
 * @property integer $port
 * @property string $transport
 * @property integer $timeout
 * @property integer $retries
 * @property string $bgpLocalAs
 * @property string $sysObjectID
 * @property string $sysDescr
 * @property string $sysContact
 * @property string $version
 * @property string $hardware
 * @property string $features
 * @property string $location
 * @property string $os
 * @property boolean $status
 * @property string $status_reason
 * @property boolean $ignore
 * @property boolean $disabled
 * @property integer $uptime
 * @property integer $agent_uptime
 * @property string $last_polled
 * @property string $last_poll_attempted
 * @property float $last_polled_timetaken
 * @property float $last_discovered_timetaken
 * @property string $last_discovered
 * @property string $last_ping
 * @property float $last_ping_timetaken
 * @property string $purpose
 * @property string $type
 * @property string $serial
 * @property string $icon
 * @property integer $poller_group
 * @property boolean $override_sysLocation
 * @property string $notes
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereDeviceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereHostname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereSysName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereIp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereCommunity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereAuthlevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereAuthname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereAuthpass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereAuthalgo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereCryptopass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereCryptoalgo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereSnmpver($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog wherePort($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereTransport($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereTimeout($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereRetries($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereBgpLocalAs($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereSysObjectID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereSysDescr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereSysContact($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereVersion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereHardware($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereFeatures($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereLocation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereOs($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereStatusReason($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereIgnore($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereDisabled($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereUptime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereAgentUptime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereLastPolled($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereLastPollAttempted($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereLastPolledTimetaken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereLastDiscoveredTimetaken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereLastDiscovered($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereLastPing($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereLastPingTimetaken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog wherePurpose($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereSerial($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereIcon($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog wherePollerGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereOverrideSysLocation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Eventlog whereNotes($value)
 * @mixin \Eloquent
 */
class Eventlog extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'devices';
    /**
     * The primary key column name.
     *
     * @var string
     */
    protected $primaryKey = 'event_id';


    // ---- Accessors/Mutators ----


    // ---- Define Reletionships ----

    /**
     * Returns the device this entry belongs to.
     */
    public function device()
    {
        return $this->belongsToOne('App\Models\Device', 'device_id', 'host');
    }
}
