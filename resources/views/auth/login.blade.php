@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-offset-4 col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title center-block">
                    <img class="logon-logo" src="images/librenms_logo_light.svg">
                </h3>
            </div>
            <div class="panel-body">
                <div class="container-fluid">
                    <form class="form-horizontal" role="form" action="{{ url('/login') }}" method="post" name="logonform">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}"">
                            <div class="col-md-12">
                                <input type="text" name="username" id="username" value="{{ old('username') }}" class="form-control" placeholder="{{ trans('user.login.username') }}" required autofocus />
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input type="password" name="password" id="password" class="form-control" placeholder="{{ trans('user.login.password') }}" />
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" id="remember" /> {{ trans('user.login.remember') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-block" name="submit" type="submit">
                                    <i class="fa fa-btn fa-sign-in"></i> {{ trans('button.login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
