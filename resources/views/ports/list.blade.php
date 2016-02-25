@extends('layouts.app')

@include('includes.datatables', ['datatables' => ['ports-table']])

@section('title', 'Ports')

@section('content')
<div class="card">
    <div class="card-body">
        <table id="ports-table" class="table table-striped">
            <thead>
                <tr>
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
                    <td>{{ $port->device_id }}</td>
                    <td>{{ $port->ifAlias }}</td>
                    <td>{{ $port->ifSpeed }}</td>
                    <td></td>
                    <td></td>
                    <td>{{ $port->ifType }}</td>
                    <td>{{ $port->ifDescr }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
