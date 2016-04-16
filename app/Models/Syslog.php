<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Syslog
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
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereDeviceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereHostname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereSysName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereIp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereCommunity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereAuthlevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereAuthname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereAuthpass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereAuthalgo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereCryptopass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereCryptoalgo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereSnmpver($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog wherePort($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereTransport($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereTimeout($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereRetries($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereBgpLocalAs($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereSysObjectID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereSysDescr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereSysContact($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereVersion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereHardware($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereFeatures($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereLocation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereOs($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereStatusReason($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereIgnore($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereDisabled($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereUptime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereAgentUptime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereLastPolled($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereLastPollAttempted($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereLastPolledTimetaken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereLastDiscoveredTimetaken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereLastDiscovered($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereLastPing($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereLastPingTimetaken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog wherePurpose($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereSerial($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereIcon($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog wherePollerGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereOverrideSysLocation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Syslog whereNotes($value)
 * @mixin \Eloquent
 */
class Syslog extends Model
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
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
    protected $primaryKey = 'null';


    // ---- Accessors/Mutators ----


    // ---- Define Reletionships ----

    /**
     * Returns the device this entry belongs to.
     */
    public function device()
    {
        return $this->belongsToOne('App\Models\Device', 'device_id', 'device_id');
    }

}
