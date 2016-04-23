@extends('layouts.app')

@include('includes.datatables')

@section('title', 'Alerts')

@section('content')
{!! $dataTable->table() !!}
@endsection

@section('scripts')
{!! $dataTable->scripts() !!}
@endsection
