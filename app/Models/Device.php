<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Device
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Port[] $ports
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Syslog[] $syslogs
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Eventlog[] $eventlogs
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereDeviceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereHostname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereSysName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereIp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereCommunity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereAuthlevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereAuthname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereAuthpass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereAuthalgo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereCryptopass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereCryptoalgo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereSnmpver($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device wherePort($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereTransport($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereTimeout($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereRetries($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereBgpLocalAs($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereSysObjectID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereSysDescr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereSysContact($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereVersion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereHardware($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereFeatures($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereLocation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereOs($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereStatusReason($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereIgnore($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereDisabled($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereUptime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereAgentUptime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereLastPolled($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereLastPollAttempted($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereLastPolledTimetaken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereLastDiscoveredTimetaken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereLastDiscovered($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereLastPing($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereLastPingTimetaken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device wherePurpose($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereSerial($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereIcon($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device wherePollerGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereOverrideSysLocation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereNotes($value)
 * @mixin \Eloquent
 */
class Device extends Model
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
    protected $primaryKey = 'device_id';

    /**
     * Initialize this class
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function(Device $device) {
            // delete related data
            $device->ports()->delete();
            $device->syslogs()->delete();
            $device->eventlogs()->delete();
        });
    }

    // ---- Define Reletionships ----

    /**
     * Returns a list of users that can access this device.
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'devices_perms', 'device_id', 'user_id');
    }

    /**
     * Returns a list of the ports this device has.
     */
    public function ports()
    {
        return $this->hasMany('App\Models\Port', 'device_id', 'device_id');
    }

    /**
     * Returns a list of the Syslog entries this device has.
     */
    public function syslogs()
    {
        return $this->hasMany('App\Models\Syslog', 'device_id', 'device_id');
    }

    /**
     * Returns a list of the Eventlog entries this device has.
     */
    public function eventlogs()
    {
        return $this->hasMany('App\Models\Eventlog', 'device_id', 'device_id');
    }

    // ---- Accessors/Mutators ----

    public function getIpAttribute($ip)
    {
        if (!empty($ip)) {
            return inet_ntop($ip);
        }
        return null;
    }

    public function setIpAttribute($ip)
    {
        $this->attributes['ip'] = inet_pton($ip);
    }

}