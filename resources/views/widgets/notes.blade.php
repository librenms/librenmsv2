@extends('layouts.widget')

@if ($action == 'settings')

<?php
    if (!isset($widget_settings))
    {
        $widget_settings = new stdClass();
        $widget_settings->tile_width = 10;
        $widget_settings->mode       = 0;
    }
?>

    @section('settings')
    <div class="form-group">
        {{ Form::label('notes', trans('widgets.label.notes'), array('class' => 'col-sm-3')) }}
        <div class="col-sm-9">
            {{ Form::textarea('notes', (isset($widget_settings->notes))  ? $widget_settings->notes : '', array('class' => 'form-control')) }}
        </div>
    </div>
    @endsection

@else
    @section('content')
    {!! (isset($widget_settings->notes))  ? stripslashes(nl2br($widget_settings->notes)) : '' !!}
    @endsection
@endif

@section('scripts')
@endsection
