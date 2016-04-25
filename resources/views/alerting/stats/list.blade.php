@extends('layouts.app')

@include('includes.flot')

@section('title', 'Alerting statistics')

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <i class="fa fa-bar-chart-o"></i>
        <h3 class="box-title">{{ trans('alerting.stats.text.title') }}</h3>
        <div class="box-tools pull-right">
            <div class="btn-group" data-toggle="btn-toggle">
                <button type="button" class="btn btn-success btn-sm" id="reset-graph" data-toggle="on">{{ trans('alerting.stats.btn.reset') }}</button>
            </div>
        </div>
    </div>
    <div class="box-body">
        <div id="alerting-logs" style="height: 300px;"></div>
    </div>
</div>
@endsection

@section('scripts')
<script>
var options = {
    lines: {
        show: true
    },
    points: {
        show: true
    },
    xaxis: {
        mode: "time",
        timeformat: "%Y-%m-%d"
    },
	selection: {
	       mode: "x"
	},
    grid: {
	       hoverable: true,
    }
};

var data = [
    @foreach ($output as $data)
        { label: "{!! $data['label'] !!}",
        data: [
            @foreach ($data['data'] as $val)
                [{!! $val[0] !!}, {!! $val[1] !!}],
            @endforeach
        ]},
    @endforeach
];

var placeholder = $("#alerting-logs");

placeholder.bind("plotselected", function (event, ranges) {

    $("#selection").text(ranges.xaxis.from.toFixed(1) + " to " + ranges.xaxis.to.toFixed(1));

    $.each(plot.getXAxes(), function(_, axis) {
        var opts = axis.options;
        opts.min = ranges.xaxis.from;
        opts.max = ranges.xaxis.to;
    });
    plot.setupGrid();
    plot.draw();
    plot.clearSelection();

});

$("<div id='tooltip'></div>").css({
    position: "absolute",
    display: "none",
    border: "2px solid #fdd",
    padding: "2px",
    "background-color": "#fee",
    opacity: 0.85
}).appendTo("body");

placeholder.bind("plothover", function (event, pos, item) {
    if (item) {
        var x = item.datapoint[0].toFixed(2),
            y = item.datapoint[1].toFixed(2);

        $("#tooltip").html(item.series.label + " (" + Math.floor(y) + ")")
            .css({top: item.pageY+5, left: item.pageX+5})
            .fadeIn(200);
    } else {
        $("#tooltip").hide();
    }
});

var plot = $.plot(placeholder, data, options);

$('#reset-graph').click('', function(event) {
    event.preventDefault();
    var plot = $.plot(placeholder, data, options);
});

</script>
@endsection
