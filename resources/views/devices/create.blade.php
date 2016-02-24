@extends('layouts.app')

@section('title', 'Add Device')

@section('content')
<form name="form1" method="post" action="{{ route('devices.store') }}" class="form-horizontal" role="form">
{!! csrf_field() !!}
  <div><h2>Add Device</h2></div>
  <div class="alert alert-info">Devices will be checked for Ping and SNMP reachability before being probed. Only devices with recognised OSes will be added.</div>
  <div class="well well-lg">
    <div class="form-group">
      <label for="hostname" class="col-sm-3 control-label">Hostname</label>
      <div class="col-sm-9">
        <input type="text" id="hostname" name="hostname" class="form-control input-sm" placeholder="Hostname">
      </div>
    </div>
    <div class="form-group">
      <label for="snmpver" class="col-sm-3 control-label">SNMP Version</label>
      <div class="col-sm-3">
        <select name="snmpver" id="snmpver" class="form-control input-sm" onChange="changeForm();">
          <option value="v1">v1</option>
          <option value="v2c" selected>v2c</option>
          <option value="v3">v3</option>
        </select>
      </div>
      <div class="col-sm-3">
        <input type="text" name="port" placeholder="port" class="form-control input-sm">
      </div>
      <div class="col-sm-3">
        <select name="transport" id="transport" class="form-control input-sm">
<option value='udp'>udp</option><option value='udp6'>udp6</option><option value='tcp'>tcp</option><option value='tcp6'>tcp6</option>        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="port_association_mode" class="col-sm-3 control-label">Port Association Mode</label>
      <div class="col-sm-3">
        <select name="port_assoc_mode" id="port_assoc_mode" class="form-control input-sm">
          <option value="ifIndex" selected>ifIndex</option>
          <option value="ifName" >ifName</option>
          <option value="ifDescr" >ifDescr</option>
          <option value="ifAlias" >ifAlias</option>
          <option value="ifAlias" >ifAlias</option>
        </select>
      </div>
    </div>
    <div id="snmpv1_2">
      <div class="form-group">
        <div class="col-sm-12 alert alert-info">
          <label class="control-label text-left input-sm">SNMPv1/2c Configuration</label>
        </div>
      </div>
      <div class="form-group">
        <label for="community" class="col-sm-3 control-label">Community</label>
        <div class="col-sm-9">
          <input type="text" name="community" id="community" placeholder="Community" class="form-control input-sm">
        </div>
      </div>
    </div>
    <div id="snmpv3">
      <div class="form-group">
        <div class="col-sm-12 alert alert-info">
          <label class="control-label text-left input-sm">SNMPv3 Configuration</label>
        </div>
      </div>
      <div class="form-group">
        <label for="authlevel" class="col-sm-3 control-label">Auth Level</label>
        <div class="col-sm-3">
          <select name="authlevel" id="authlevel" class="form-control input-sm">
            <option value="noAuthNoPriv" selected>noAuthNoPriv</option>
            <option value="authNoPriv">authNoPriv</option>
            <option value="authPriv">authPriv</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="authname" class="col-sm-3 control-label">Auth User Name</label>
        <div class="col-sm-9">
          <input type="text" name="authname" id="authname" class="form-control input-sm">
        </div>
      </div>
      <div class="form-group">
        <label for="authpass" class="col-sm-3 control-label">Auth Password</label>
        <div class="col-sm-9">
          <input type="text" name="authpass" id="authpass" placeholder="AuthPass" class="form-control input-sm">
        </div>
      </div>
      <div class="form-group">
        <label for="authalgo" class="col-sm-3 control-label">Auth Algorithm</label>
        <div class="col-sm-9">
          <select name="authalgo" id="authalgo" class="form-control input-sm">
            <option value="MD5" selected>MD5</option>
            <option value="SHA">SHA</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="cryptopass" class="col-sm-3 control-label">Crypto Password</label>
        <div class="col-sm-9">
          <input type="text" name="cryptopass" id="cryptopass" placeholder="Crypto Password" class="form-control input-sm">
        </div>
      </div>
      <div class="form-group">
        <label for="cryptoalgo" class="col-sm-3 control-label">Crypto Algorithm</label>
        <div class="col-sm-9">
          <select name="cryptoalgo" id="cryptoalgo" class="form-control input-sm">
            <option value="AES" selected>AES</option>
            <option value="DES">DES</option>
          </select>
        </div>
      </div>
    </div>
    <hr>
    <center><button type="submit" class="btn btn-default" name="Submit">Add Device</button></center>
  </div>
</form>
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
    $('#snmpv3').toggle();
</script>
@endsection
