@extends('layouts.app')

@include('includes.datatables')

@section('title', trans('nav.devices.main'))

@section('content-header')
    <h1>
        {{ trans('nav.devices.main') }}
        <small>{{ $group_name ?: trans('general.text.all') }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> {{ trans('nav.home') }}</a></li>
        @if($group_name)
            <li><a href="{{ url('devices') }}">{{ trans('nav.devices.main') }}</a></li>
            <li class="active">{{ $group_name }}</li>
        @else
            <li class="active">{{ trans('nav.devices.main') }}</li>
        @endif
    </ol>
@endsection

@section('content')
{!! $dataTable->table() !!}
@endsection

@section('scripts')
{!! $dataTable->scripts() !!}
@endsection
