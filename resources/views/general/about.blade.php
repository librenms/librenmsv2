@extends('layouts.app')

@section('title', 'About')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
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
                <dl class="dl-horizontal">
                    <dt>Apache</dt>
                    <dd>{{ $versions['apache'] }}</a></dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>PHP</dt>
                    <dd>{{ $versions['php'] }}</a></dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>MySQL</dt>
                    <dd>{{ $versions['mysql'] }}</a></dd>
                </dl>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-body">
                <h3>About</h3>
                <p>LibreNMS is a community-based project. Please feel free to join us and contribute code, documentation, and bug reports. Some important links can be found below.</p>
                <ol class="breadcrumb">
                    <li><a href="http://www.librenms.org/">Web site</a></li>
                    <li><a href="https://github.com/librenms/">GitHub</a></li>
                    <li><a href="https://github.com/librenms/librenms/issues">Bug tracker</a></li>
                    <li><a href="https://groups.google.com/forum/#!forum/librenms-project">Mailing list</a></li>
                    <li><a href="http://twitter.com/librenms">Twitter</a></li>
                    <li><a href="http://www.librenms.org/changelog.html">Changelog</a></li>
                    <li><a href="#" data-toggle="modal" data-target="#git_log">Git log</a></li>
                </ol>
                <h3>Contributors</h3>
                <p>See the <a href="https://github.com/librenms/librenms/blob/master/AUTHORS.md">list of contributors</a> on GitHub.</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <i class="fa fa-line-chart"></i>
                <h3 class="box-title">Statistics</h3>
            </div>
            <div class="box-body">
                <table class="table">
                    <tr>
                        <td><i class="fa fa-server"></i> Devices</td>
                        <td><span class="badge bg-blue">{{ $stats['devices'] }}</span></td>
                        <td><i class="fa fa-link"></i> Ports</td>
                        <td><span class="badge bg-blue">{{ $stats['ports'] }}</span></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-envelope-o"></i> IPv4 Addresses</td>
                        <td><span class="badge bg-blue">{{ $stats['ipv4_addr'] }}</span></td>
                        <td><i class="fa fa-envelope-o"></i> IPv4 Networks</td>
                        <td><span class="badge bg-blue">{{ $stats['ipv4_net'] }}</span></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-envelope-o"></i> IPv6 Addresses</td>
                        <td><span class="badge bg-blue">{{ $stats['ipv6_addr'] }}</span></td>
                        <td><i class="fa fa-envelope-o"></i> IPv6 Networks</td>
                        <td><span class="badge bg-blue">{{ $stats['ipv6_net'] }}</span></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-cogs"></i> Services</td>
                        <td><span class="badge bg-blue">{{ $stats['services'] }}</span></td>
                        <td><i class="fa fa-tasks"></i> Applications</td>
                        <td><span class="badge bg-blue">{{ $stats['apps'] }}</span></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-desktop"></i> Processors</td>
                        <td><span class="badge bg-blue">{{ $stats['processors'] }}</span></td>
                        <td><i class="fa fa-gears"></i> Memory</td>
                        <td><span class="badge bg-blue">{{ $stats['memory'] }}</span></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-database"></i> Storage</td>
                        <td><span class="badge bg-blue">{{ $stats['storage'] }}</span></td>
                        <td><i class="fa fa-database"></i> Disk I/O</td>
                        <td><span class="badge bg-blue">{{ $stats['diskio'] }}</span></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-cubes"></i> HR-MIB</td>
                        <td><span class="badge bg-blue">{{ $stats['hrmib'] }}</span></td>
                        <td><i class="fa fa-cubes"></i> Entity-MIB</td>
                        <td><span class="badge bg-blue">{{ $stats['entmib'] }}</span></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-book"></i> Syslog entries</td>
                        <td><span class="badge bg-blue">{{ $stats['syslog'] }}</span></td>
                        <td><i class="fa fa-book"></i> Eventlog entries</td>
                        <td><span class="badge bg-blue">{{ $stats['eventlog'] }}</span></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-tachometer"></i> Sensors</td>
                        <td><span class="badge bg-blue">{{ $stats['sensors'] }}</span></td>
                        <td><i class="fa fa-print"></i> Toner</td>
                        <td><span class="badge bg-blue">{{ $stats['toner'] }}</span></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-header">
                <i class="fa fa-file-text-o"></i>
                <h3 class="box-title">License</h3>
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
@endsection
