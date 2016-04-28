@extends('layouts.app')

@include('includes.datatables')

@section('title', trans('nav.devices.main'))

@section('content-header')
    <h1>
        {{ trans('nav.devices.main') }}
        <small>{{ trans('general.text.list') }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> {{ trans('nav.home') }}</a></li>
        <li class="active">{{ trans('nav.devices.main') }}</li>
    </ol>
@endsection

@section('content')
<div class="container">
<div class="card">
    <div class="card-body">
        @if (count($devices))
        <table id="devices-table" class="table table-striped">
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
       @else
       <h2>No Devices</h2>
       <a href="{{ url('/devices/create') }}">Add one</a>
       @endif

    </div>
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
