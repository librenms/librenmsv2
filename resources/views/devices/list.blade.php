@extends('layouts.app')

@include('includes.datatables')

@section('title', 'Devices')

@section('content')
<div class="card">
    <div class="card-body">
        @if (count($devices))
        <table id="devices-table" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Vendor</th>
                    <th>Hostname</th>
                    <th>Platform</th>
                    <th>Operating System</th>
                    <th>Uptime/Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Status</th>
                    <th>Vendor</th>
                    <th>Hostname</th>
                    <th>Platform</th>
                    <th>Operating System</th>
                    <th>Uptime/Location</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($devices as $device)
                <tr>
                    <td>
                    @if ($device->status == 0)
                        <span class="label label-danger">{{ $device->status_reason }}</span>
                    @else
                        <span class="label label-success">up</span>
                    @endif
                    </td>
                    <td><img alt="{{ $device->os }}" src="{{ $device->logo() }}"/></td>
                    <td>{{ $device->hostname }}</td>
                    <td>{{ $device->hardware }}<br/>{{ $device->features }}</td>
                    <td>{{ $device->os }}&nbsp;{{ $device->version }}</td>
                    <td>{{ $device->uptime }}<br/>{{ $device->location }}</td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
        </table>
       @else
       <h2>No Devices</h2>
       <a href="{{ url('/devices/create') }}">Add one</a>
       @endif

    </div>
</div>
@endsection

@section('scripts')
<script>
  $(function () {
    $('#devices-table').DataTable();
  });
</script>
@endsection
