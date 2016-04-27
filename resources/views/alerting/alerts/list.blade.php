@extends('layouts.app')

@include('includes.datatables')

@section('title', trans('nav.overview.alerts.main'))

@section('content-header')
    <h1>
        {{ trans('nav.overview.alerts.main') }}
        <small>{{ trans('alerting.alerts.current') }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> {{ trans('nav.home') }}</a></li>
        <li><a href="{{ url('/alerting') }}">{{ trans('nav.overview.alerts.alerting') }}</a></li>
        <li class="active">{{ trans('nav.overview.alerts.main') }}</li>
    </ol>
@endsection

@section('content')
{!! $dataTable->table(['class' => 'table table-hover']) !!}
@endsection

@section('scripts')
    {!! $dataTable->scripts() !!}
    <script src="{{ url('js/core/alerting.js') }}"></script>
@endsection
