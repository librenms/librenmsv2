@if($status == 0)
    <span data-toggle="tooltip" title="down" class="device-status label label-danger">{{ $status_reason }}</span>
@else
    <span data-toggle="tooltip" title="up" class="device-status label label-success">up</span>
@endif
