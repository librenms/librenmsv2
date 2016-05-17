@extends('layouts.widget')

@if ($action == 'settings')

    @section('settings')
    @endsection

@else
    @section('content')
        @if ($params->{'data-source'} == 'rrd-json')
            <canvas id="myChart" width="400" height="200"></canvas>
        @endif
    @endsection
@endif

@section('scripts')
<script>

var ctx = document.getElementById("myChart");

$.ajax({
    url: '/api/rrd',
    async: true,
    dataType: 'json',
    type: "get",
}).done(function (data) {
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.labels,
            datasets: data.data
        },
        options: {
            responsive: true,
            legend: {
                position: 'bottom',
            },
            hover: {
                mode: 'label'
            },
            scales: {
                yAxes: [{
                    stacked: false,
                    ticks: {
                        callback: function(tick, index, ticks) {
                            return BKMGT(tick, index, ticks);
                        }
                    },

                }],
                xAxes: [{
                    stacked: true,
                    type: 'time',
                }],
            }
        }
    });
});

function BKMGT (y, index, ticks) {
    var abs_y = Math.abs(y);
    if (abs_y >= 1000000000000)   { return y / 1000000000000 + "T" }
    else if (abs_y >= 1000000000) { return y / 1000000000 + "G" }
    else if (abs_y >= 1000000)    { return y / 1000000 + "M" }
    else if (abs_y >= 1000)       { return y / 1000 + "K" }
    else if (abs_y < 1 && y > 0)  { return y.toFixed(2) }
    else if (abs_y === 0)         { return '' }
    else                      { return y }

}
</script>
@endsection
