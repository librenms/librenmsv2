<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="show-graph"
                     id="{{ $device->device_id }}_device_bits"
                     data-type="device_bits"
                     data-graph="csv"
                     data-width="100%"
                     data-height="400px"
                     data-start="-24h"
                     data-end="-300"
                     data-options='{"drawGrid": true, "legend": "always" }'
                     data-device="{{ $device->device_id }}"
                     style="border-bottom-width:1px; border-bottom-color:black; border-bottom-style: solid;"
                ></div>
            </div>
        </div>
    </div>
</div>

@include('includes.datatables')

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border" id="device-eventlog">

            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        $(document).ready(function() {
            $.get('/widget-data/eventlog').done(function (output) {
                console.log(output);
                $('#device-eventlog').html(output);
            });
        });
    </script>
@endsection