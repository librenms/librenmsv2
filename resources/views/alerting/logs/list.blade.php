@extends('layouts.app')

@include('includes.datatables')

@section('title', 'Logs')

@section('content')
{!! $dataTable->table(['class' => 'table table-hover']) !!}
@endsection

@section('scripts')
{!! $dataTable->scripts() !!}
@endsection
