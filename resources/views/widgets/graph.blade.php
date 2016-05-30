@extends('layouts.widget')

@if ($action == 'settings')

    @section('settings')
    <div class="form-group">
        {{ Form::label('output_type', trans('widgets.label.output_type'), array('class' => 'col-sm-3')) }}
        <div class="col-sm-9">
            {{ Form::select('output_type', array('0' => trans('widgets.text.dynamic'),
                                            '1' => trans('widgets.text.png')
                            ), (isset($widget_settings->output_type))  ? $widget_settings->output_type : '', array('class' => 'form-control')) }}
        </div>
    </div>
    @endsection

@else
    @section('content')
        @if ($params->{'data-source'} == 'rrd-json')
            <canvas id="ctx_{{ $div_id }}" width="400" height="150"></canvas>
        @endif
    @endsection
@endif

@section('scripts')
    @if ($action != 'settings')
        @if ($params->{'data-source'} == 'rrd-json')
            <script>
            var ctx_{{ $div_id }} = document.getElementById("ctx_{{ $div_id }}");
            $.Graphs.callGraph(ctx_{{ $div_id }});
            </script>
        @endif
    @endif
@endsection
