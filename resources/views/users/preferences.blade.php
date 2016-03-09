@extends('layouts.app')

@section('title', 'Preferences')

@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <i class="fa fa-user"></i>
                <h3 class="box-title">Change password</h3>
            </div>
            <div class="box-body">
                    {!! Form::open(array('url' => 'preferences', 'method' => 'post')) !!}
                    {{ Form::bsPassword('current_password', [], '' , 'col-sm-3') }}
                    {{ Form::bsPassword('new_password', [], '' , 'col-sm-3') }}
                    {{ Form::bsPassword('repeat_password', [], '' , 'col-sm-3') }}
                    {{ Form::bsHorizSubmit('Update password', 'btn-primary')}}
                    {!! Form::close() !!}
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <i class="fa fa-lock"></i>
                <h3 class="box-title">Device / Port permissions</h3>
            </div>
            <div class="box-body">
                @if (Auth::user()->isAdmin())
                    <strong class='text-light-blue'>Global Administrative Access</strong>
                @elseif (Auth::user()->hasGlobalRead())
                    <strong class='text-green'>Global Viewing Access</strong>
                @elseif (isset($devices) || isset($ports))
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>{{ $devices }}</h3>
                                    <p>Devices</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-server"></i>
                                </div>
                                <a href="{{ url('/devices') }}" class="small-box-footer">
                                    Show devices <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>{{ $ports }}</h3>
                                    <p>Ports</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-link"></i>
                                </div>
                                <a href="{{ url('/ports') }}" class="small-box-footer">
                                    Show ports <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                    <strong class='text-red'>No access!</strong>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script src="{{ url('js/util.js') }}"></script>
    @if ($updated === true)
        <script>
            $.Util.toastr('info', 'Password has been updated');
        </script>
    @endif
@endsection
