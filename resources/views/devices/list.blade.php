@extends('layouts.app')

@section('title', 'Devices')

@section('content')

<div class="card">
    <div class="card-body">
        <table id="devices" class="datatable table table-striped">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Hostname</th>
                    <th>OS</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Status</th>
                    <th>Hostname</th>
                    <th>OS</th>
                    <th>Status</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($devices as $device)
                <tr>
                    <td>
                    @if ($device->status === 0)
                        <span class="label label-danger">{{ $device->status_reason }}</span>
                    @else
                        <span class="label label-success">up</span>
                    @endif
                    </td>
                    <td>{{ $device->hostname }}</td>
                    <td>{{ $device->os }}</td>
                    <td>{{ $device->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
