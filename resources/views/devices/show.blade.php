@extends('layouts.app')

@section('title', trans('nav.devices.main'))

@section('content-header')
    <h1>
        {{ trans('nav.devices.main') }}
        <small>{{ trans('general.text.list') }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> {{ trans('nav.home') }}</a></li>
        <li class="active">{{ trans('nav.devices.main') }}</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-6">
        <div id="graphs"></div>
    </div>
</div>
@endsection

@section('scripts')

<script>

$.get('/widget-data/generic-graph/?id=', function () {
})
.done(function(output) {
    $('#graphs').append(output);
})
.fail(function(err,msg) {
    console.log('error');
});
</script>
@endsection
