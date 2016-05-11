@extends('layouts.app')

@section('title', 'Edit User')

@section('content-header')
    <h1>
        Edit User
        <small>{{ $user->username }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> {{ trans('nav.home') }}</a></li>
        <li><a href="{{ url('/users') }}">{{ trans('nav.settings.users') }}</a></li>
        <li class="active">Edit</li>
    </ol>
@endsection

@section('content')
<div class="container">

<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">User Info</h3>
            </div>
            <div class="box-body">
                {!! Form::open(['method' => 'PUT', 'route' => ['users.update', $user->user_id], 'class'=>'form-horizontal']) !!}
                {{ Form::hidden('user_id', $user->user_id) }}
                {{ Form::bsText('realname', $user->realname) }}
                {{ Form::bsText('username', $user->username) }}
                {{ Form::bsSelect('level', ['1' => trans('user.level.1'), '5' => trans('user.level.5'), '10' => trans('user.level.10')]) }}
                {{ Form::bsText('email', $user->email) }}
                {{ Form::bsText('descr', $user->descr) }}
                {{ Form::bsSubmit('Save', 'btn-primary') }}
                {!! Form::close() !!}
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Password</h3>
            </div>
            <div class="box-body">
                {!! Form::open(['method' => 'PUT', 'route' => ['users.update', $user->user_id], 'class'=>'form-horizontal']) !!}
                {{ Form::bsPassword('password') }}
                {{ Form::bsPassword('password_confirmation') }}
                {{ Form::bsSubmit(' Save', 'btn-primary') }}
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box box-primary">
            @if($user->hasGlobalRead())
                <div class="box-header with-border">
                    <h3 class="box-title">Device Permissions</h3>
                </div>
                <div class="box-body">
                    User has Access to all devices.
                </div>
            @else
                <div class="box-header with-border">
                    <h3 class="box-title">Device Permissions</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool showModal" data-toggle="modal" data-href="{{ route('users.devices.create', $user->user_id) }}" data-target="#generalModal" data-modal-title="Add Device">
                            <i class="fa fa-plus"></i> Add Device
                        </button>
                    </div>
                </div>
                <div class="box-body" style="max-height: 30em;overflow-y: auto;">
                    <ul class="list-unstyled">
                    @foreach($user->devices as $device)
                        <li>
                            <div class="remove-target" >
                                {{ Form::open(['route' => ['users.devices.destroy', $user->user_id, $device->device_id], 'method' => 'delete']) }}
                                <a href="{{ route('devices.show', [$device->device_id]) }}">{{ $device->hostname }}</a>
                                <i class="fa fa-times-circle text-danger remove-icon" style="cursor: pointer;"></i>
                                {{ Form::close() }}
                            </div>
                        </li>
                    @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="box box-primary">
        @if($user->hasGlobalRead())
            <div class="box-header with-border">
                <h3 class="box-title">Port Permissions</h3>
                <small>User also has access to all ports on devices</small>
            </div>
            <div class="box-body">
                User has Access to all ports.
            </div>
        @else
            <div class="box-header with-border">
                <h3 class="box-title">Port Permissions</h3>
                <small>User also has access to all ports on devices</small>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool showModal" data-toggle="modal" data-href="{{ route('users.ports.create', $user->user_id) }}" data-target="#generalModal" data-modal-title="Add Port">
                        <i class="fa fa-plus"></i> Add Port
                    </button>
                </div>
            </div>
            <div class="box-body" style="max-height: 30em;overflow-y: auto;">
                <ul class="list-unstyled">
                    @foreach($user->ports as $port)
                        <li>
                            <div class="remove-target" >
                                {{ Form::open(['route' => ['users.ports.destroy', $user->user_id, $port->port_id], 'method' => 'delete']) }}
                                <a href="{{ route('ports.show', [$port->port_id]) }}">{{ $port->device->hostname . ": " . $port->getLabel() }}</a>
                                <i class="fa fa-times-circle text-danger remove-icon" style="cursor: pointer;"></i>
                                {{ Form::close() }}
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
        </div>
    </div>
</div>

@include('components.modals.general')

</div>
@endsection

@section('scripts')
    @if(Session::has('message'))
        <script>
            $(document).ready(function() {
                toastr['{{ Session::get('type') }}']('{{ Session::get('message') }}');
            });
        </script>
    @endif
    <script type="text/javascript">
        $(document).on('click', '.remove-icon', function(e) {
            $(this).parent().submit();
        });

        $(document).on('click', '.modalSave', function(e) {
            $('.modalForm').submit();
        });
    </script>
    @include('includes.modal')
@endsection