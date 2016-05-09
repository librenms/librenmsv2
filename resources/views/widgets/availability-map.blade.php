@extends('layouts.widget')

@section('content')

<center><span data-toggle="tooltip" title="" class="badge bg-green" data-original-title="{{ $count['up'] }} Devices up">{{ $count['up'] }}</span> <span data-toggle="tooltip" title="" class="badge bg-yellow" data-original-title="{{ $count['warn'] }} Recently rebooted">{{ $count['warn'] }}</span> <span data-toggle="tooltip" title="" class="badge bg-red" data-original-title="{{ $count['down'] }} Devices down">{{ $count['down'] }}</span></h5></center>

<?php $count = ['warn' => 0, 'up' => 0, 'down' => 0]; ?>
@foreach ($devices as $device)

    @if ($device->status == 1)
        @if ($device->uptime < $uptime && $device->uptime != '0')
            <?php $btn = "warning"; ?>
        @else
            <?php $btn = "success"; ?>
        @endif
    @else
        <?php $btn = "danger"; ?>
    @endif
    <a href="{{ url("devices/".$device->device_id) }}" role="button" class="btn btn-{{ $btn }} btn-xs" title="{{ $device->hostname }} {{ $device->formatUptime($device->uptime) }}" style="min-height:10px; min-width:10px; border-radius:0px; margin:0px; padding:0px;"></a>
@endforeach
@endsection

@section('scripts')
@endsection
