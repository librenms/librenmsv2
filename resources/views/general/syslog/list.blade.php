@extends('layouts.app')

@include('includes.datatables')

@section('title', 'Syslog')

@section('content')
{!! $dataTable->table() !!}
@endsection

@section('scripts')
{!! $dataTable->scripts() !!}
@endsection
