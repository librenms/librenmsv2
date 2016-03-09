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
                <h3 class="box-title">Device permissions</h3>
            </div>
            <div class="box-body">
                @if (Auth::user()->isAdmin())
                    <strong class='text-light-blue'>Global Administrative Access</strong>
                @elseif (Auth::user()->hasGlobalRead())
                    <strong class='text-green'>Global Viewing Access</strong>
                @elseif (count($devices))
                    @foreach ($devices as $device)
                        <a href="{{ url('/device/'.$device->device_id) }}">{{ $device->hostname }}</a><br />
                    @endforeach
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
