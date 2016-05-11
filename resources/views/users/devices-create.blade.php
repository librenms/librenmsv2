<div style="max-height: 30em; overflow-y: auto">
{{ Form::open(['route' => ['users.devices.store', $user->user_id], 'class' => 'modalForm']) }}
@foreach(\App\Models\Device::all()->diff($user->devices) as $device)
    {{ Form::checkbox('devices[]', $device->device_id)}} {{ $device->hostname }} <br />
@endforeach
{{ Form::bsSubmit('Save', 'btn-primary modalFooterContent modalSave')}}
{{ Form::close() }}
</div>