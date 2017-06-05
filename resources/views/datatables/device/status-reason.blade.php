@if($disabled == 1)
    <div class="device-status" title="Disabled" style="background:grey;"></div>
@elseif($ignore == 1)
    <div class="device-status" title="Ignored" style="background:yellow;"></div>
@elseif($status == 0)
    <div class="device-status" title="Down" style="background:red;"></div>
@elseif($status == 1)
    <div class="device-status" title="Up" style="background:green;"></div>
@endif
