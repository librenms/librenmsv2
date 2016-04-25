@extends('layouts.app')

@include('includes.datatables')

@section('title', 'Logs')

@section('content')
{!! $dataTable->table() !!}
@endsection

@section('scripts')
{!! $dataTable->scripts() !!}
@endsection
