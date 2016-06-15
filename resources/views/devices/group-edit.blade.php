{!! Form::open(['route' => ['device-groups.store'], 'class'=>'deviceGroupForm form-horizontal modalForm']) !!}
    {{ isset($group) ? Form::hidden('id', $group->id) : ''}}
    {{ Form::bsText('name', isset($group) ? $group->name : '') }}
    {{ Form::bsText('desc', isset($group) ? $group->descr : '', [], null, trans('devices.groups.desc')) }}
    {{ Form::bsText('pattern', isset($group) ? $group->pattern : '') }}

    {{ Form::bsSubmit('Save', ['class' => 'btn-primary modalFooterContent modalSave'])}}
{!! Form::close() !!}