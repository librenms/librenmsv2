<section class="col-lg-6 connectedSortable">
    <div class="nav-tabs-custom">
        <!-- Tabs within a box -->
        <ul class="nav nav-tabs pull-right">
            <li><a href="#snmp-v3" data-toggle="tab">v3</a></li>
            <li class="active"><a href="#snmp-common" data-toggle="tab">Common</a></li>
            <li class="pull-left header"><i class="fa fa-tags"></i>SNMP Defaults</li>
        </ul>

        <div class="tab-content no-padding">
            <!-- Morris chart - Sales -->
            <div class="box-body tab-pane active" id="snmp-common">
                {!! Form::open(['url' => 'api/settings', 'class'=>'form-horizontal', 'role'=>'form']) !!}

                <div class="form-group">
                    <label for="snmp.version" class="col-sm-3 control-label">Version</label>
                    <div class="col-sm-9">
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-primary {{ Settings::get('snmp.version')=='v1' ? 'active' : '' }}">
                                {!! Form::input('radio', 'snmp.version', 'v1') !!}
                                v1 </label>
                            <label class="btn btn-primary {{ Settings::get('snmp.version')=='v2c' ? 'active' : '' }}">
                                {!! Form::input('radio', 'snmp.version', 'v2c') !!}
                                v2c </label>
                            <label class="btn btn-primary {{ Settings::get('snmp.version')=='v3' ? 'active' : '' }}">
                                {!! Form::input('radio', 'snmp.version', 'v3') !!}
                                v3 </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="snmp.community.0" class="col-sm-3 control-label">Community</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="snmp.community.0" placeholder="Community"
                               value="{{ Settings::get('snmp.community.0') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="snmp.port" class="col-sm-3 control-label">Port</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="snmp.port" placeholder="Community"
                               value="{{ Settings::get('snmp.port') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="snmp.transport" class="col-sm-3 control-label">Transport</label>
                    <div class="col-sm-3">
                        <ul id="snmp.transport-list" class="list-group" style="margin-bottom:0;">
                            <li data-id="0" class="list-group-item"><span class="drag-handle fa fa-bars"></span> udp
                            </li>
                            <li data-id="1" class="list-group-item"><span class="drag-handle fa fa-bars"></span> udp6
                            </li>
                            <li data-id="2" class="list-group-item"><span class="drag-handle fa fa-bars"></span> tcp
                            </li>
                            <li data-id="3" class="list-group-item"><span class="drag-handle fa fa-bars"></span> tcp6
                            </li>
                        </ul>
                    </div>
                </div>

                {!! Form::close() !!}
            </div>

            <div class="box-body tab-pane" id="snmp-v3">
                {!! Form::open(['url' => 'api/settings', 'class'=>'form-horizontal', 'role'=>'form']) !!}
                <div class="form-group">
                    <label for="snmp.v3.0.authlevel" class="col-sm-3 control-label">AuthLevel</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="snmp.v3.0.authlevel" placeholder="AuthLevel"
                               value="{{ Settings::get('snmp.v3.0.authlevel') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="snmp.v3.0.authname" class="col-sm-3 control-label">AuthName</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="snmp.v3.0.authname" placeholder="AuthName"
                               value="{{ Settings::get('snmp.v3.0.authname') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="snmp.v3.0.authalgo" class="col-sm-3 control-label">AuthAlgo</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="snmp.v3.0.authalgo" placeholder="AuthAlgo"
                               value="{{ Settings::get('snmp.v3.0.authalgo') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="snmp.v3.0.authpass" class="col-sm-3 control-label">AuthPass</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="snmp.v3.0.authpass" placeholder="AuthPass"
                               value="{{ Settings::get('snmp.v3.0.authpass') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="snmp.v3.0.cryptopass" class="col-sm-3 control-label">CryptoAlgo</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="snmp.v3.0.crytpoalgo" placeholder="CryptoAlgo"
                               value="{{ Settings::get('snmp.v3.0.cryptoalgo') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="snmp.v3.0.cryptoalgo" class="col-sm-3 control-label">CryptoPass</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="snmp.v3.0.crytpopass" placeholder="CryptoPass"
                               value="{{ Settings::get('snmp.v3.0.cryptopass') }}">
                    </div>
                </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>
</section>


@section('scripts')
    <script src="http://rubaxa.github.io/Sortable/Sortable.js"></script>
    <script>
        var list = document.getElementById("snmp.transport-list");
        Sortable.create(list, {
            handle: '.drag-handle',
            animation: 150
        });
    </script>
@endsection
