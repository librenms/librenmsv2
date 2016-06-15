<div style="max-height: 30em; overflow-y: auto">
    {{ Form::open(['route' => ['users.devices.store', $user->user_id], 'class' => 'modalForm']) }}
    @foreach(\App\Models\Device::all()->diff($user->devices) as $device)
        <div class="checkbox">
            <label>
                {{ Form::checkbox('devices[]', $device->device_id)}} {{ $device->hostname }} <br/>
            </label>
        </div>
    @endforeach
    {{ Form::bsSubmit(trans('button.save'), ['class' => 'btn-primary modalFooterContent modalSave'])}}
    {{ Form::close() }}
</div>