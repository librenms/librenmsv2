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
            {{ Form::ajaxDynamicText('snmp.community', Settings::get('snmp.community', [], true), array_merge(Settings::isReadOnly('snmp.community') ? ['disabled'] : [], ['label' =>trans('settings.snmp.community')])) }}
            {{ Form::ajaxSortable('snmp.transports', trans('settings.snmp.transports'), ['udp', 'udp6', 'tcp', 'tcp6']) }}

        </div>

        <div class="box-body tab-pane form-horizontal" id="snmp-v3">

            @foreach(Settings::get('snmp.v3', [], true) as $group => $settings)
                @foreach($settings as $key => $value)
                    {{ Form::bsText(implode('.', ['snmp.v3', $group, $key]), $value, array_merge(Settings::isReadOnly(implode('.', ['snmp.v3', $group, $key])) ? ['disabled'] : [], ['label' =>trans('settings.snmp.v3.'.$key)])) }}
                @endforeach
            @endforeach

        </div>
    </div>
</div>
