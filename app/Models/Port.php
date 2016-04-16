<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Port
 *
 * @property integer $port_id
 * @property integer $device_id
 * @property string $port_descr_type
 * @property string $port_descr_descr
 * @property string $port_descr_circuit
 * @property string $port_descr_speed
 * @property string $port_descr_notes
 * @property string $ifDescr
 * @property string $ifName
 * @property string $portName
 * @property integer $ifIndex
 * @property integer $ifSpeed
 * @property string $ifConnectorPresent
 * @property string $ifPromiscuousMode
 * @property integer $ifHighSpeed
 * @property string $ifOperStatus
 * @property string $ifAdminStatus
 * @property string $ifDuplex
 * @property integer $ifMtu
 * @property string $ifType
 * @property string $ifAlias
 * @property string $ifPhysAddress
 * @property string $ifHardType
 * @property string $ifLastChange
 * @property string $ifVlan
 * @property string $ifTrunk
 * @property integer $ifVrf
 * @property integer $counter_in
 * @property integer $counter_out
 * @property boolean $ignore
 * @property boolean $disabled
 * @property boolean $detailed
 * @property boolean $deleted
 * @property string $pagpOperationMode
 * @property string $pagpPortState
 * @property string $pagpPartnerDeviceId
 * @property string $pagpPartnerLearnMethod
 * @property integer $pagpPartnerIfIndex
 * @property integer $pagpPartnerGroupIfIndex
 * @property string $pagpPartnerDeviceName
 * @property string $pagpEthcOperationMode
 * @property string $pagpDeviceId
 * @property integer $pagpGroupIfIndex
 * @property integer $ifInUcastPkts
 * @property integer $ifInUcastPkts_prev
 * @property integer $ifInUcastPkts_delta
 * @property integer $ifInUcastPkts_rate
 * @property integer $ifOutUcastPkts
 * @property integer $ifOutUcastPkts_prev
 * @property integer $ifOutUcastPkts_delta
 * @property integer $ifOutUcastPkts_rate
 * @property integer $ifInErrors
 * @property integer $ifInErrors_prev
 * @property integer $ifInErrors_delta
 * @property integer $ifInErrors_rate
 * @property integer $ifOutErrors
 * @property integer $ifOutErrors_prev
 * @property integer $ifOutErrors_delta
 * @property integer $ifOutErrors_rate
 * @property integer $ifInOctets
 * @property integer $ifInOctets_prev
 * @property integer $ifInOctets_delta
 * @property integer $ifInOctets_rate
 * @property integer $ifOutOctets
 * @property integer $ifOutOctets_prev
 * @property integer $ifOutOctets_delta
 * @property integer $ifOutOctets_rate
 * @property integer $poll_time
 * @property integer $poll_prev
 * @property integer $poll_period
 * @property-read \App\Models\Device $device
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port wherePortId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereDeviceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port wherePortDescrType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port wherePortDescrDescr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port wherePortDescrCircuit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port wherePortDescrSpeed($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port wherePortDescrNotes($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfDescr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port wherePortName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfIndex($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfSpeed($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfConnectorPresent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfPromiscuousMode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfHighSpeed($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfOperStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfAdminStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfDuplex($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfMtu($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfAlias($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfPhysAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfHardType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfLastChange($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfVlan($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfTrunk($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfVrf($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereCounterIn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereCounterOut($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIgnore($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereDisabled($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereDetailed($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereDeleted($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port wherePagpOperationMode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port wherePagpPortState($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port wherePagpPartnerDeviceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port wherePagpPartnerLearnMethod($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port wherePagpPartnerIfIndex($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port wherePagpPartnerGroupIfIndex($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port wherePagpPartnerDeviceName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port wherePagpEthcOperationMode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port wherePagpDeviceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port wherePagpGroupIfIndex($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfInUcastPkts($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfInUcastPktsPrev($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfInUcastPktsDelta($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfInUcastPktsRate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfOutUcastPkts($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfOutUcastPktsPrev($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfOutUcastPktsDelta($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfOutUcastPktsRate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfInErrors($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfInErrorsPrev($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfInErrorsDelta($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfInErrorsRate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfOutErrors($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfOutErrorsPrev($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfOutErrorsDelta($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfOutErrorsRate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfInOctets($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfInOctetsPrev($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfInOctetsDelta($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfInOctetsRate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfOutOctets($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfOutOctetsPrev($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfOutOctetsDelta($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port whereIfOutOctetsRate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port wherePollTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port wherePollPrev($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Port wherePollPeriod($value)
 * @mixin \Eloquent
 */
class Port extends Model
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
    protected $table = 'ports';
    /**
     * The primary key column name.
     *
     * @var string
     */
    protected $primaryKey = 'port_id';


    // ---- Accessors/Mutators ----


    // ---- Define Reletionships ----

    /**
     * Get the device this port belongs to.
     *
     */
    public function device()
    {
        return $this->belongsTo('App\Models\Device', 'device_id', 'device_id');
    }

    /**
     * Returns a list of users that can access this port.
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'ports_perms', 'port_id', 'user_id');
    }

}
