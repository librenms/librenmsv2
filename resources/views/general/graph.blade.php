@extends('layouts.app')

@section('title', trans('nav.settings.about'))

@section('content-header')
    <h1>
        {{ trans('nav.settings.about') }}
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> {{ trans('nav.home') }}</a></li>
        <li class="active">{{ trans('nav.settings.about') }}</li>
    </ol>
@endsection

@section('content')
<style>
#chart_container {
        position: relative;
        font-family: Arial, Helvetica, sans-serif;
}
#chart {
        position: relative;
        left: 40px;
}
#y_axis {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 40px;
}
#legend {
    position: absolute;
    top: 0;
    bottom: 0;
    left:480px;
}
#preview {
	margin-top: 10px;
    left: 40px;
}
</style>
<div id="content">

	<div id="chart_container">
		<div id="chart"></div>
        <div id="y_axis"></div>
        <div id="legend"></div>
		<div id="timeline"></div>
        <div id="preview"></div>
	</div>

</div>

@endsection

@section('scripts')
<script>

var palette = new Rickshaw.Color.Palette( { scheme: 'classic9' } );

// instantiate our graph!
var graph;
graph = new Rickshaw.Graph.Ajax( {
    element: document.getElementById("chart"),
    width: 400,
	height: 300,
	renderer: 'line',
    stack: false,
    padding: {
        top: 0.1
    },
    dataURL: '/api/rrd',
    onData: function(d) {
        return d;
    },
    onComplete: function(transport) {
                    var ticksTreatment = 'glow';
                    var graph = transport.graph;
                    var yAxis = new Rickshaw.Graph.Axis.Y({
                        graph: graph,
                        orientation: 'left',
                        tickFormat: Rickshaw.Fixtures.Number.formatKMGT(),
                        element: document.getElementById('y_axis'),
                    });
                    var legend = new Rickshaw.Graph.Legend({
                        graph: graph,
                        element: document.getElementById('legend')
                    });
                    var detail = new Rickshaw.Graph.HoverDetail({
                        graph: graph,
                        tickFormat: Rickshaw.Fixtures.Number.formatKMGT(),
                    });
                    var preview = new Rickshaw.Graph.RangeSlider.Preview({
                    	graph: graph,
                    	element: document.getElementById('preview'),
                    });
                    var previewXAxis = new Rickshaw.Graph.Axis.Time({
                    	graph: preview.previews[0],
                    	timeFixture: new Rickshaw.Fixtures.Time.Local(),
                    	ticksTreatment: ticksTreatment
                    });
                    var xAxis = new Rickshaw.Graph.Axis.Time( {
                    	graph: graph,
                    	ticksTreatment: ticksTreatment,
                    	timeFixture: new Rickshaw.Fixtures.Time.Local()
                    } );
                    xAxis.render();
                    previewXAxis.render();
                    yAxis.render();
    },
    series: [
        {
            name: 'RAM Used',
            color: palette.color(),
        },
        {
            name: '-Sh,Bu,Ca',
            color: palette.color(),
        },
        {
            name: "RAM Free",
            color: palette.color(),
        },
        {
            name: "Swap used",
            color: palette.color(),
        },
        {
            name: "% of RAM",
            color: palette.color(),
        },
        {
            name: "Shared",
            color: palette.color(),
        },
        {
            name: "Buffered",
            color: palette.color(),
        },
        {
            name: "Cached",
            color: palette.color(),
        },
        {
            name: "Total",
            color: palette.color(),
        }
    ]
});
</script>

@endsection
