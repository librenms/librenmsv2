<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\General\Syslog
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
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereDeviceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereHostname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereSysName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereIp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereCommunity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereAuthlevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereAuthname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereAuthpass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereAuthalgo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereCryptopass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereCryptoalgo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereSnmpver($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog wherePort($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereTransport($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereTimeout($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereRetries($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereBgpLocalAs($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereSysObjectID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereSysDescr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereSysContact($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereVersion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereHardware($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereFeatures($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereLocation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereOs($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereStatusReason($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereIgnore($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereDisabled($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereUptime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereAgentUptime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereLastPolled($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereLastPollAttempted($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereLastPolledTimetaken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereLastDiscoveredTimetaken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereLastDiscovered($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereLastPing($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereLastPingTimetaken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog wherePurpose($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereSerial($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereIcon($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog wherePollerGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereOverrideSysLocation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereNotes($value)
 * @mixin \Eloquent
 * @property string $facility
 * @property string $priority
 * @property string $level
 * @property string $tag
 * @property string $timestamp
 * @property string $program
 * @property string $msg
 * @property integer $seq
 * @property-read \App\Models\Device $device
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereFacility($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog wherePriority($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereTag($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereTimestamp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereProgram($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereMsg($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereSeq($value)
 */
class Syslog extends Model
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
    protected $table = 'syslog';
    /**
     * The primary key column name.
     *
     * @var string
     */
    protected $primaryKey = 'seq';


    // ---- Accessors/Mutators ----


    // ---- Define Reletionships ----

    /**
     * Returns the device this entry belongs to.
     */
    public function device()
    {
        return $this->belongsTo('App\Models\Device', 'device_id', 'device_id');
    }
}
