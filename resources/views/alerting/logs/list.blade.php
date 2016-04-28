@extends('layouts.app')

@include('includes.datatables')

@section('title', trans('nav.overview.alerts.log'))

@section('content-header')
    <h1>
        {{ trans('nav.overview.alerts.log') }}
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> {{ trans('nav.home') }}</a></li>
        <li><a href="{{ url('/alerting') }}">{{ trans('nav.overview.alerts.alerting') }}</a></li>
        <li class="active">{{ trans('nav.overview.alerts.main') }}</li>
    </ol>
@endsection

@section('content')
{!! $dataTable->table() !!}
@endsection

@section('scripts')
{!! $dataTable->scripts() !!}
@endsection
