@extends('layouts.app')

@include('includes.datatables')

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
{!! $dataTable->table() !!}
@endsection

@section('scripts')
{!! $dataTable->scripts() !!}
@endsection
