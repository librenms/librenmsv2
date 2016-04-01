<section class="col-lg-6 connectedSortable">
    <div class="nav-tabs-custom">
        <!-- Tabs within a box -->
        <ul class="nav nav-tabs pull-right">
            <li><a href="#snmp-v3" data-toggle="tab">v3</a></li>
            <li class="active"><a href="#snmp-common" data-toggle="tab">Common</a></li>
            <li class="pull-left header"><i class="fa fa-tags"></i>SNMP Defaults</li>
        </ul>

        <div class="tab-content no-padding">
            <div class="box-body tab-pane form-horizontal active" id="snmp-common">

                @include('settings.widgets.radio', ['setting'=>'snmp.version', 'label'=>'Default Version', 'items'=>['v1', 'v2c', 'v3']])
                @include('settings.widgets.text', ['setting'=>'snmp.community.0', 'label'=>'Community'])
                @include('settings.widgets.text', ['setting'=>'snmp.port', 'label'=>'Port'])
                @include('settings.widgets.sortable', ['setting'=>'snmp.transports', 'label'=>'Transport Order', 'default'=>['udp','udp6','tcp','tcp6']])

            </div>

            <div class="box-body tab-pane form-horizontal" id="snmp-v3">

                @include('settings.widgets.text', ['setting'=>'snmp.v3.0.authlevel', 'label'=>'AuthLevel'])
                @include('settings.widgets.text', ['setting'=>'snmp.v3.0.authname', 'label'=>'AuthName'])
                @include('settings.widgets.text', ['setting'=>'snmp.v3.0.authalgo', 'label'=>'AuthAlgo'])
                @include('settings.widgets.text', ['setting'=>'snmp.v3.0.authpass', 'label'=>'AuthPass'])
                @include('settings.widgets.text', ['setting'=>'snmp.v3.0.cryptoalgo', 'label'=>'CryptoAlgo'])
                @include('settings.widgets.text', ['setting'=>'snmp.v3.0.cryptopass', 'label'=>'CryptoPass'])

            </div>
        </div>
    </div>
</section>
