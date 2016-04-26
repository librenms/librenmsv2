@extends('layouts.app')

@include('includes.datatables')

@section('title', 'Eventlogs')

@section('content')
{!! $dataTable->table() !!}
@endsection

@section('scripts')
{!! $dataTable->scripts() !!}
@endsection
