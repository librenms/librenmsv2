@extends('layouts.app')

@include('includes.datatables')

@section('title', trans('nav.overview.eventlog'))

@section('content-header')
    <h1>
        {{ trans('nav.overview.eventlog') }}
        <small>{{ trans('nav.devices.all') }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> {{ trans('nav.home') }}</a></li>
        <li class="active">{{ trans('nav.overview.eventlog') }}</li>
    </ol>
@endsection

@section('content')
{!! $dataTable->table() !!}
@endsection

@section('scripts')
{!! $dataTable->scripts() !!}
@endsection
