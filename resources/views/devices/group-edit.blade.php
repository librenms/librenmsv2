@if (isset($group))
    {!! Form::model($group, ['route' => ['device-groups.update', $group->id], 'method' => 'PUT', 'class' => 'form-horizontal modalForm']) !!}
@else
    {!! Form::open(['route' => ['device-groups.store'], 'method' => 'POST', 'class' => 'form-horizontal modalForm']) !!}
@endif

    {{ Form::bsText('name') }}
    {{ Form::bsText('desc', null, ['label' => trans('devices.groups.desc')]) }}
    {{ Form::bsText('pattern') }}

    {{ Form::bsSubmit('Save', ['class' => 'btn-primary modalFooterContent modalSave'])}}
{!! Form::close() !!}