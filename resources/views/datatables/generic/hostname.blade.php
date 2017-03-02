<a href="{{ isset($device_id) ? url("devices/".$device_id) : '' }}">
    {{ isset($device, $device['hostname']) ? $device['hostname'] : \App\Models\Device::find($device_id)->hostname ?: __('Device deleted') }}
</a>
