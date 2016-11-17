    @extends('layouts.widget')

@if ($action == 'settings')

    @section('settings')
    <div class="form-group">
        {{ Form::label('output_type', trans('widgets.label.output_type'), array('class' => 'col-sm-3')) }}
        <div class="col-sm-9">
            {{ Form::select('output_type', array('0' => trans('widgets.text.dynamic'),
                                            '1' => trans('widgets.text.png'),
                            ), (isset($widget_settings->output_type))  ? $widget_settings->output_type : '', array('class' => 'form-control')) }}
        </div>
    </div>
    @endsection

@else
    @section('content')
        <div class="resizable-graph" id="ctx_{{ $div_id }}" width="400" height="150"></div>
    @endsection
@endif

@section('scripts')
    @if ($action != 'settings')
        <script>
            var ctx_{{ $div_id }} = document.getElementById("ctx_{{ $div_id }}");
            @if ($params->{'data-source'} == 'rrd-json')
                $.Graphs.callJsonGraph(ctx_{{ $div_id }});
            @elseif ($params->{'data-source'} == 'rrd-png')
                $.Graphs.callPNGGraph(ctx_{{ $div_id }});
            @elseif ($params->{'data-source'} == 'rrd-csv')
                $.Graphs.callCsvGraph(ctx_{{ $div_id }});
            @endif
        </script>
    @endif
@endsection
