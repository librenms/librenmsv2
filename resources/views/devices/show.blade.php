@extends('layouts.app')

@section('title', trans('nav.devices.main'))

@section('content-header')
@endsection

@section('content')
    <!-- Device overview box -->
    <div class="row">
        <div class="col-md-12">
            <div class="box box-{{ $device->status_colour() }}">
                <div class="box-header with-border">
                    <div class="col-md-1">
                        <img src="{{ $device->logo() }}" border="0" alt="{{ $device->os }}">
                    </div>
                    <div class="col-md-4">
                        <h3 class="box-title"><strong>{{ $device->hostname() }}</strong></h3><br />
                        <span>{{ $device->location() }}</span>
                    </div>
                    <div class="col-md-6">
                        @foreach ($device->config{'over'} as $id => $over)
                            <div class="show-graph"
                                 id="{{ $device->device_id }}_{{ $over{'graph'} }}"
                                 data-type="{{ $over{'graph'} }}"
                                 data-graph="csv"
                                 data-width="100%"
                                 data-height="20px"
                                 data-start="-24h"
                                 data-end="-300"
                                 data-device="{{ $device->device_id }}"
                                 data-drawaxis="false"
                                 style="border-bottom-width:1px; border-bottom-color:black; border-bottom-style: solid;"
                            ></div>
                        @endforeach
                    </div>
                    <div class="col-md-1">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Device sub-menu -->
    <div class="row">
        <div class="col-md-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <img class="img-responsive img-circle pull-right" src="{{ $device->logo() }}" alt="{{ $device->os }}">
                            <strong>{{ $device->hostname() }}</strong><br />
                            <span>{{ $device->location() }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Details:</h3>
                        </div>
                        <div class="box-body">
                            <strong><i class="fa fa-book margin-r-5"></i> System Name</strong>
                            <p class="text-muted">
                                {{ $device->sysName }}
                            </p>
                            @if ($device->location)
                                <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
                                <p class="text-muted">
                                    {{ $device->location() }}
                                </p>
                            @endif
                            @if ($device->sysContact)
                                <strong><i class="fa fa-envelope-o margin-r-5"></i> Contact</strong>
                                <p class="text-muted">
                                    {{ $device->sysContact }}
                                </p>
                            @endif
                            @if ($device->hardware)
                                <strong><i class="fa fa-gears margin-r-5"></i> Hardware</strong>
                                <p class="text-muted">
                                    {{ $device->hardware }}
                                </p>
                            @endif
                            @if ($device->sysContact)
                                <strong><i class="fa fa-envelope-o margin-r-5"></i> Operating System</strong>
                                <p class="text-muted">
                                    {{ Settings::get('os.'.$device->{'os'}.'text') . ' ' . $device->version . ' ' . $device->features }}
                                </p>
                            @endif
                            @if ($device->serial)
                                <strong><i class="fa fa-envelope-o margin-r-5"></i> Serial</strong>
                                <p class="text-muted">
                                    {{ $device->serial }}
                                </p>
                            @endif
                            <hr>
                            <strong><i class="fa fa-link"></i> Ports</strong>
                            <p>
                                <span class="label label-success">{{ $device->ports()->isUp()->count() }}</span>
                                <span class="label label-default">{{ $device->ports()->isIgnored()->count() }}</span>
                                <span class="label label-danger">{{ $device->ports()->isDown()->count() }}</span>
                            </p>
                            <strong><i class="fa fa-heartbeat"></i> Sensors</strong>
                            <p>
                                <span class="label label-success">{{ $device->sensors()->count() }}</span>
                            </p>
                            <strong><i class="fa fa-cogs"></i> Services</strong>
                            <p>
                                @foreach ($device->services()->get() as $service)
                                    <span class="label label-success">{{ $service->service_type }}</span>
                                @endforeach
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    @foreach ($page_setup['navbar'] as $navtitle => $navurl)
                        <li
                        @if ($request->url() == $navurl)
                            class="active"
                        @endif
                        ><a href="{{ $navurl }}">{{ $navtitle }}</a></li>
                        @endforeach
                        <li class="pull-right">
                            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-cog"></i>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="https://{{ $device->hostname() }}" target="_blank"><i class="fa fa-link text-success"></i> Web</a></li>
                                <li><a href="ssh://{{ $device->hostname() }}" target="_blank"><i class="fa fa-lock text-success"></i> SSH</a></li>
                                <li><a href="telnet://localhost" target="_blank"><i class="fa fa-unlock text-success"></i> Telnet</a></li>
                                <li><a href="{{ url("devices/".$device->device_id."/edit/") }}"><i class="fa fa-wrench text-success"></i> Edit</a></li>
                                <li><a href="{{ url("devices/".$device->device_id."/capture/") }}"><i class="fa fa-video-camera text-success"></i> Capture</a></li>
                            </ul>
                        </li>
                </ul>
                <div class="tab-content">
                    @include('devices.page.' . strtolower($page))
                </div>
            </div>
        </div>
    </div>

    <div class="row">
    </div>
@endsection

@section('scripts')
@endsection
