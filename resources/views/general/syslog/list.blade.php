@extends('layouts.app')

@include('includes.datatables')

@section('title', trans('nav.overview.syslog'))

@section('content-header')
    <h1>
        {{ trans('nav.overview.syslog') }}
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> {{ trans('nav.home') }}</a></li>
        <li class="active">{{ trans('nav.overview.syslog') }}</li>
    </ol>
@endsection

@section('content')
{!! $dataTable->table() !!}
@endsection

@section('scripts')
{!! $dataTable->scripts() !!}
@endsection
