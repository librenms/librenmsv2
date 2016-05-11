@extends('layouts.app')

@section('title', trans('user.preferences.main'))

@section('content-header')
    <h1>
        {{ trans('user.preferences.main') }}
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> {{ trans('nav.home') }}</a></li>
        <li class="active">{{ trans('user.preferences.main') }}</li>
    </ol>
@endsection

@section('content')
<div class="container">
<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <i class="fa fa-user"></i>
                <h3 class="box-title">{{ trans('user.preferences.change') }}</h3>
            </div>
            <div class="box-body">
                    {!! Form::open(['url' => 'preferences', 'method' => 'post', 'class'=>'form-horizontal']) !!}
                    {{ Form::bsPassword('current_password') }}
                    {{ Form::bsPassword('password') }}
                    {{ Form::bsPassword('password_confirmation') }}
                    {{ Form::bsSubmit('Update password', 'btn-primary')}}
                    {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <i class="fa fa-lock"></i>
                <h3 class="box-title">{{ trans('user.preferences.permissions') }}</h3>
            </div>
            <div class="box-body">
                @if (Auth::user()->isAdmin())
                    <strong class='text-light-blue'>{{ trans('user.preferences.adminaccess') }}</strong>
                @elseif (Auth::user()->hasGlobalRead())
                    <strong class='text-green'>{{ trans('user.preferences.viewaccess') }}</strong>
                @elseif (isset($devices) || isset($ports))
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>{{ $devices }}</h3>
                                    <p>{{ trans('user.preferences.devices') }}</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-server"></i>
                                </div>
                                <a href="{{ url('/devices') }}" class="small-box-footer">
                                    {{ trans('user.preferences.showdevices') }} <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>{{ $ports }}</h3>
                                    <p>{{ trans('user.preferences.ports')}}</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-link"></i>
                                </div>
                                <a href="{{ url('/ports') }}" class="small-box-footer">
                                    {{ trans('user.preferences.showports') }} <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                    <strong class='text-red'>{{ trans('user.preferences.noaccess') }}</strong>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    @if ($updated === true)
        <script>
            toastr.info("{{ trans('user.preferences.pwdupdated') }}");
        </script>
    @endif
@endsection
