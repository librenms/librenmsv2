@extends('layouts.app')

@include('includes.datatables')

@section('title', trans('nav.overview.inventory'))

@section('content-header')
    <h1>
        {{ trans('nav.overview.inventory') }}
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> {{ trans('nav.home') }}</a></li>
        <li class="active">{{ trans('nav.overview.inventory') }}</li>
    </ol>
@endsection

@section('content')
{!! $dataTable->table(['class' => 'table table-hover']) !!}
@endsection

@section('scripts')
{!! $dataTable->scripts() !!}
@endsection
