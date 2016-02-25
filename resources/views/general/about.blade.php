@extends('layouts.app')

@section('title', 'About')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="box box-solid">
            <div class="box-header with-border">
                <i class="fa fa-exclamation-circle"></i>
                <h3 class="box-title">LibreNMS is an autodiscovering PHP/MySQL-based network monitoring system.</h3>
            </div>
            <div class="box-body">
                <dl class="dl-horizontal">
                    <dt>Version</dt>
                    <dd><a href="http://www.librenms.org/changelog.html" target="_blank">{{ $versions['git'] }}</a></dd>
                </dl>
                    <dl class="dl-horizontal">
                        <dt>DB Schema</dt>
                        <dd>{{ $versions['db_schema'] }}</a></dd>
                    </dl>
            </div>
        </div>
    </div>
    <div class="col-md-6">
    </div>
</div>
@endsection
