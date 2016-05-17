<section class="col-lg-6 connectedSortable">
    <div class="nav-tabs-custom">
        <!-- Tabs within a box -->
        <ul class="nav nav-tabs pull-right">
            <li><a href="#snmp-v3" data-toggle="tab">{{ trans('settings.snmp.tabs.v3') }}</a></li>
            <li class="active"><a href="#snmp-common" data-toggle="tab">{{ trans('settings.snmp.tabs.common') }}</a></li>
            <li class="pull-left header"><i class="fa fa-tags"></i>{{ trans('settings.snmp.title') }}</li>
        </ul>

        <div class="tab-content no-padding">
            <div class="box-body tab-pane form-horizontal active" id="snmp-common">

                {{ Form::ajaxRadio('snmp.version', trans('settings.snmp.version'), ['v1', 'v2c', 'v3']) }}
                {{ Form::ajaxText('snmp.community.0', trans('settings.snmp.community')) }}
                {{ Form::ajaxSortable('snmp.transports', trans('settings.snmp.transports'), ['udp', 'udp6', 'tcp', 'tcp6']) }}

            </div>

            <div class="box-body tab-pane form-horizontal" id="snmp-v3">

                {{ Form::ajaxText('snmp.v3.0.authlevel', trans('settings.snmp.v3.authlevel')) }}
                {{ Form::ajaxText('snmp.v3.0.authname', trans('settings.snmp.v3.authname')) }}
                {{ Form::ajaxText('snmp.v3.0.authalgo', trans('settings.snmp.v3.authalgo')) }}
                {{ Form::ajaxText('snmp.v3.0.authpass', trans('settings.snmp.v3.authpass')) }}
                {{ Form::ajaxText('snmp.v3.0.cryptoalgo', trans('settings.snmp.v3.cryptoalgo')) }}
                {{ Form::ajaxText('snmp.v3.0.cryptopass', trans('settings.snmp.v3.cryptopass')) }}

            </div>
        </div>
    </div>
</section>
