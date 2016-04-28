@extends('layouts.app')

@include('includes.datatables')

@section('title', trans('nav.overview.eventlog'))

@section('content-header')
    <h1>
        {{ trans('nav.overview.eventlog') }}
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> {{ trans('nav.home') }}</a></li>
        <li class="active">{{ trans('nav.overview.eventlog') }}</li>
    </ol>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <table id="ports-table" class="table table-striped">
            <thead>
                <tr>
                    <th>Port ID</th>
                    <th>Device ID</th>
                    <th>Device</th>
                    <th>Port</th>
                    <th>Speed</th>
                    <th>Down</th>
                    <th>Up</th>
                    <th>Media</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ports as $port)
                <tr>
                    <td>{{ $port->port_id }}</td>
                    <td>{{ $port->device_id }}</td>
                    <td>{{ $port->device->hostname }}</td>
                    <td>{{ $port->ifAlias }}</td>
                    <td>{{ $port->ifSpeed }}</td>
                    <td>{{ $port->ifOutUcastPkts_delta }}</td>
                    <td>{{ $port->ifInUcastPkts_delta }}</td>
                    <td>{{ $port->ifType }}</td>
                    <td>{{ $port->ifDescr }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
        <script src="{{ url('js/util.js') }}"></script>
        <script>
            $(function () {
                $('#ports-table').DataTable( {
                    stateSave: true,
                    "columnDefs": [
                    {
                            "targets": [ 0, 1],
                            "visible": false,
                            "searchable": false
                        },
                        {
                            "targets": 2,
                            "render": function ( data, type, row, meta ) {
                                if (type == "display"){
                                    return '<a href="/devices/'+row[1]+'">'+data+'</a>';
                                }
                                return data;
                            }
                        },
                        {
                            "targets": 3,
                            "render": function ( data, type, row, meta ) {
                                if (type == "display"){
                                    return '<a href="/devices/'+row[1]+'/ports/'+row[0]+'">'+data+'</a>';
                                }
                                return data;
                            }
                        },                        {
                            "targets": [4, 5, 6],
                            "render": function ( data, type, row, meta ) {
                                if (type == "display"){
                                    if (data == 0) return '';
                                    return $.Util.formatBitsPS(data);
                                }
                                return data;
                            }
                        },
                    ]
                } );
            } );
        </script>
@endsection
