@extends('layouts.app')

@section('title', trans('nav.settings.about'))

@section('content-header')
    <h1>
        {{ trans('nav.settings.about') }}
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> {{ trans('nav.home') }}</a></li>
        <li class="active">{{ trans('nav.settings.about') }}</li>
    </ol>
@endsection

@section('content')
<div class="container">

<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <i class="fa fa-exclamation-circle"></i>
                <h3 class="box-title">{{ trans('about.text.descr') }}</h3>
            </div>
            <div class="box-body">
                <dl class="dl-horizontal">
                    <dt>{{ trans('about.text.version') }}</dt>
                    <dd><a href="http://www.librenms.org/changelog.html" target="_blank">{{ $versions['git'] }}</a></dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>{{ trans('about.text.schema') }}</dt>
                    <dd>{{ $versions['db_schema'] }}</a></dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>{{ trans('about.text.php') }}</dt>
                    <dd>{{ $versions['php'] }}</a></dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>{{ $versions['db_driver'] }}</dt>
                    <dd>{{ $versions['db_version'] }}</a></dd>
                </dl>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-body">
                <h3>{{ trans('about.text.about') }}</h3>
                <p>{{ trans('about.text.summary') }}</p>
                <ol class="breadcrumb">
                    <li><a href="http://www.librenms.org/">{{ trans('about.link.site') }}</a></li>
                    <li><a href="https://github.com/librenms/">{{ trans('about.link.github') }}</a></li>
                    <li><a href="https://github.com/librenms/librenms/issues">{{ trans('about.link.bugs') }}</a></li>
                    <li><a href="https://groups.google.com/forum/#!forum/librenms-project">{{ trans('about.link.mailing') }}</a></li>
                    <li><a href="http://twitter.com/librenms">{{ trans('about.link.twitter') }}</a></li>
                    <li><a href="http://www.librenms.org/changelog.html">{{ trans('about.link.changelog') }}</a></li>
                    <li><a href="#" data-toggle="modal" data-target="#git_log">{{ trans('about.link.gitlog') }}</a></li>
                </ol>
                <h3></h3>
                <p>{!! trans('about.link.contributors', ['url' => 'https://github.com/librenms/librenms/blob/master/AUTHORS.md']) !!}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <i class="fa fa-line-chart"></i>
                <h3 class="box-title">{{ trans('about.text.stats') }}</h3>
            </div>
            <div class="box-body">
                <table class="table">
                    <tr>
                        <td><i class="fa fa-server"></i> {{ trans('about.statistics.devices') }}</td>
                        <td><span class="badge bg-blue">{{ $stats['devices'] }}</span></td>
                        <td><i class="fa fa-link"></i> {{ trans('about.statistics.ports') }}</td>
                        <td><span class="badge bg-blue">{{ $stats['ports'] }}</span></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-envelope-o"></i> {{ trans('about.statistics.ipv4addr') }}</td>
                        <td><span class="badge bg-blue">{{ $stats['ipv4_addr'] }}</span></td>
                        <td><i class="fa fa-envelope-o"></i> {{ trans('about.statistics.ipv4net') }}</td>
                        <td><span class="badge bg-blue">{{ $stats['ipv4_net'] }}</span></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-envelope-o"></i> {{ trans('about.statistics.ipv6addr') }}</td>
                        <td><span class="badge bg-blue">{{ $stats['ipv6_addr'] }}</span></td>
                        <td><i class="fa fa-envelope-o"></i> {{ trans('about.statistics.ipv6net') }}</td>
                        <td><span class="badge bg-blue">{{ $stats['ipv6_net'] }}</span></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-cogs"></i> {{ trans('about.statistics.services') }}</td>
                        <td><span class="badge bg-blue">{{ $stats['services'] }}</span></td>
                        <td><i class="fa fa-tasks"></i> {{ trans('about.statistics.applications') }}</td>
                        <td><span class="badge bg-blue">{{ $stats['apps'] }}</span></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-desktop"></i> {{ trans('about.statistics.processors') }}</td>
                        <td><span class="badge bg-blue">{{ $stats['processors'] }}</span></td>
                        <td><i class="fa fa-gears"></i> {{ trans('about.statistics.memory') }}</td>
                        <td><span class="badge bg-blue">{{ $stats['memory'] }}</span></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-database"></i> {{ trans('about.statistics.storage') }}</td>
                        <td><span class="badge bg-blue">{{ $stats['storage'] }}</span></td>
                        <td><i class="fa fa-database"></i> {{ trans('about.statistics.diskio') }}</td>
                        <td><span class="badge bg-blue">{{ $stats['diskio'] }}</span></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-cubes"></i> {{ trans('about.statistics.hrmib') }}</td>
                        <td><span class="badge bg-blue">{{ $stats['hrmib'] }}</span></td>
                        <td><i class="fa fa-cubes"></i> {{ trans('about.statistics.entmib') }}</td>
                        <td><span class="badge bg-blue">{{ $stats['entmib'] }}</span></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-book"></i> {{ trans('about.statistics.syslog') }}</td>
                        <td><span class="badge bg-blue">{{ $stats['syslog'] }}</span></td>
                        <td><i class="fa fa-book"></i> {{ trans('about.statistics.eventlog') }}</td>
                        <td><span class="badge bg-blue">{{ $stats['eventlog'] }}</span></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-tachometer"></i> {{ trans('about.statistics.sensors') }}</td>
                        <td><span class="badge bg-blue">{{ $stats['sensors'] }}</span></td>
                        <td><i class="fa fa-print"></i> {{ trans('about.statistics.toner') }}</td>
                        <td><span class="badge bg-blue">{{ $stats['toner'] }}</span></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-header">
                <i class="fa fa-file-text-o"></i>
                <h3 class="box-title">{{ trans('about.text.license') }}</h3>
            </div>
            <div class="box-body">
                <pre>
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <a href="http://www.gnu.org/licenses/">http://www.gnu.org/licenses/</a>.
                </pre>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
    </div>
    <div class="col-md-6">
    </div>
</div>

</div>
@endsection
