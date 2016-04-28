@extends('layouts.app')

@include('includes.datatables')

@section('title', trans('nav.search'))

@section('content-header')
    <h1>
        {{ trans('nav.search') }}
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> {{ trans('nav.home') }}</a></li>
        <li class="active">{{ trans('nav.search') }}</li>
    </ol>
@endsection

@section('content')
{!! $dataTable->table(['class' => 'table table-hover']) !!}
@endsection

@section('scripts')
{!! $dataTable->scripts() !!}
@endsection
