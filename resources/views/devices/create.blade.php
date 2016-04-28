@extends('layouts.app')

@section('title', trans('nav.devices.add'))

@section('content-header')
    <h1>
        {{ trans('nav.devices.add') }}
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> {{ trans('nav.home') }}</a></li>
        <li class="active">{{ trans('nav.devices.add') }}</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <form name="add_device" method="post" action="{{ route('devices.store') }}" class="form-horizontal" role="form">
            {!! csrf_field() !!}
            <div class="callout callout-warning"><i class="icon fa fa-warning"></i> {{ trans('devices.text.warning') }}</div>
            <div class="well well-lg">
                <div class="form-group">
                    <label for="hostname" class="col-sm-3 control-label">{{ trans('devices.label.hostname') }}</label>
                    <div class="col-sm-9">
                        <input type="text" id="hostname" name="hostname" class="form-control input-sm" placeholder="{{ trans('devices.label.hostname') }}" value="{{ old('hostname') }}">
                        <div class="text-red form-error"><small>{{ $errors->first('hostname') }}</small></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="snmpver" class="col-sm-3 control-label">{{ trans('devices.label.snmpver') }}</label>
                    <div class="col-sm-3">
                        <select name="snmpver" id="snmpver" class="form-control input-sm" onChange="changeForm();">
                            <option value="v1" @if (old('snmpver') === "v1") selected @endif>v1</option>
                            <option value="v2c" @if (old('snmpver') === "v2c") selected @elseif (old('snmpver') == "") selected @endif>v2c</option>
                            <option value="v3" @if (old('snmpver') === "v3") selected @endif>v3</option>
                        </select>
                        <div class="text-red form-error"><small>{{ $errors->first('snmpver') }}</small></div>
                    </div>
                    <div class="col-sm-3">
                        <input type="text" name="port" placeholder="{{ trans('devices.label.port') }}" class="form-control input-sm" value="{{ old('port') }}">
                    </div>
                    <div class="col-sm-3">
                        <select name="transport" id="transport" class="form-control input-sm">
                            @foreach (Settings::get('snmp.transports', ['tcp', 'tcp6', 'udp', 'udp6']) as $item)
                                <option value="{{ $item }}" @if ($item === old('transport')) selected @endif>{{ $item }}</option>
                            @endforeach
                        </select>
                        <div class="text-red form-error"><small>{{ $errors->first('transport') }}</small></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="port_association_mode" class="col-sm-3 control-label">{{ trans('devices.label.portassoc') }}</label>
                    <div class="col-sm-3">
                        <select name="port_assoc_mode" id="port_assoc_mode" class="form-control input-sm">
                            <option value="ifIndex" @if (old('port_assoc_mode') === "ifIndex") selected @endif>ifIndex</option>
                            <option value="ifName" @if (old('port_assoc_mode') === "ifName") selected @endif>ifName</option>
                            <option value="ifDescr" @if (old('port_assoc_mode') === "ifDescr") selected @endif>ifDescr</option>
                            <option value="ifAlias" @if (old('port_assoc_mode') === "ifAlias") selected @endif>ifAlias</option>
                        </select>
                        <div class="text-red form-error"><small>{{ $errors->first('port_assoc_mode') }}</small></div>
                    </div>
                </div>
                <div id="snmpv1_2">
                    <div class="form-group">
                        <div class="col-sm-12 alert alert-success">
                            <label class="control-label text-left input-sm">{{ trans('devices.label.v1v2c') }}</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="community" class="col-sm-3 control-label">{{ trans('devices.label.community') }}</label>
                        <div class="col-sm-4">
                            <input type="text" name="community" id="community" placeholder="{{ trans('devices.label.community') }}" class="form-control input-sm" value="{{ old('community') }}">
                            <div class="text-red form-error"><small>{{ $errors->first('community') }}</small></div>
                        </div>
                    </div>
                </div>
                <div id="snmpv3">
                    <div class="form-group">
                        <div class="col-sm-12 alert alert-success">
                            <label class="control-label text-left input-sm">{{ trans('devices.label.v3') }}</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="authlevel" class="col-sm-3 control-label">{{ trans('devices.label.authlevel') }}</label>
                        <div class="col-sm-3">
                            <select name="authlevel" id="authlevel" class="form-control input-sm">
                                <option value="noAuthNoPriv" @if (old('authlevel') === "noAuthNoPriv") selected @endif>noAuthNoPriv</option>
                                <option value="authNoPriv" @if (old('authlevel') === "authNoPriv") selected @endif>authNoPriv</option>
                                <option value="authPriv" @if (old('authlevel') === "authPriv") selected @endif>authPriv</option>
                            </select>
                            <div class="text-red form-error"><small>{{ $errors->first('authlevel') }}</small></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="authname" class="col-sm-3 control-label">{{ trans('devices.label.authname') }}</label>
                        <div class="col-sm-9">
                            <input type="text" name="authname" id="authname" placeholder="{{ trans('devices.label.authname') }}" class="form-control input-sm" value="{{ old('authname') }}">
                            <div class="text-red form-error"><small>{{ $errors->first('authname') }}</small></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="authpass" class="col-sm-3 control-label">{{ trans('devices.label.authpass') }}</label>
                        <div class="col-sm-9">
                            <input type="text" name="authpass" id="authpass" placeholder="{{ trans('devices.label.authpass') }}" class="form-control input-sm" value="{{ old('authpass') }}">
                            <div class="text-red form-error"><small>{{ $errors->first('authpass') }}</small></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="authalgo" class="col-sm-3 control-label">{{ trans('devices.label.authalgo') }}</label>
                        <div class="col-sm-9">
                            <select name="authalgo" id="authalgo" class="form-control input-sm">
                                <option value="MD5" @if (old('authalgo') === "MD5") selected @endif>MD5</option>
                                <option value="SHA" @if (old('authalgo') === "SHA") selected @endif>SHA</option>
                            </select>
                            <div class="text-red form-error"><small>{{ $errors->first('authalgo') }}</small></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cryptopass" class="col-sm-3 control-label">{{ trans('devices.label.cryptopass') }}</label>
                        <div class="col-sm-9">
                            <input type="text" name="cryptopass" id="cryptopass" placeholder="{{ trans('devices.label.cryptopass') }}" class="form-control input-sm" value="{{ old('cryptopass') }}">
                            <div class="text-red form-error"><small>{{ $errors->first('cryptopass') }}</small></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cryptoalgo" class="col-sm-3 control-label">{{ trans('devices.label.cryptoalgo') }}</label>
                        <div class="col-sm-9">
                            <select name="cryptoalgo" id="cryptoalgo" class="form-control input-sm">
                                <option value="AES" @if (old('cryptoalgo') === "AES") selected @endif>AES</option>
                                <option value="DES" @if (old('cryptoalgo') === "DES") selected @endif>DES</option>
                            </select>
                            <div class="text-red form-error"><small>{{ $errors->first('cryptoalgo') }}</small></div>
                        </div>
                    </div>
                </div>
                @if (Settings::get('distributed_poller','false') === true)
                    <div class="form-group">
                        <label for="poller_group" class="col-sm-3 control-label">{{ trans('devices.label.pollergroup') }}</label>
                        <div class="col-sm-3">
                            <select name="poller_group" id="poller_group" class="form-control input-sm">
                                <option value="0"> Default poller group</option>
                                // Fixme
                                // Need to query DB for poller groups
                            </select>
                        </div>
                    </div>
                @endif
                <div class="checkbox">
                    <div class="col-sm-offset-3 col-sm-9">
                        <label>
                            <input type="checkbox" name="force_add" id="force_add" @if (old('force_add') === "on") checked @endif> {{ trans('devices.text.forceadd') }}
                        </label>
                    </div>
                </div>
                <hr>
                <center><button type="submit" class="btn btn-primary" name="Submit">{{ trans('devices.btn.add') }}</button></center>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function changeForm() {
        snmpVersion = $("#snmpver").val();
        if(snmpVersion == 'v1' || snmpVersion == 'v2c') {
            $('#snmpv1_2').show();
            $('#snmpv3').hide();
        }
        else if(snmpVersion == 'v3') {
            $('#snmpv1_2').hide();
            $('#snmpv3').show();
        }
    }
    @if (!empty(old('snmpver')))
        if ('{{ old('snmpver') }}' ==='v3')
        {
            $('#snmpv1_2').toggle();
        }
        else
        {
            $('#snmpv3').toggle();
        }
    @else
        $('#snmpv3').toggle();
    @endif
</script>
@endsection
