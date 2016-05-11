<div style="max-height: 30em; overflow-y: auto">
{{ Form::open(['route' => ['users.ports.store', $user->user_id], 'class' => 'modalForm']) }}
@foreach(\App\Models\Device::with('ports')->get() as $device)
    <?php $ports = $device->ports->diff($user->ports) ?>
    @if(count($ports) > 0)
        <h4>{{ $device->hostname }}</h4>
        <div class="checkbox">
            <label>
            @foreach($device->ports->diff($user->ports) as $port)
                {{ Form::checkbox('ports[]', $port->port_id) }} {{ $port->getLabel() }} <br />
            @endforeach
            </label>
        </div>
        <hr />
    @endif
@endforeach
{{ Form::bsSubmit('Save', 'btn-primary modalFooterContent modalSave')}}
{{ Form::close() }}
</div>