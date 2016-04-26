@extends('layouts.app')

@include('includes.datatables')

@section('title', 'Inventory')

@section('content')
{!! $dataTable->table() !!}
@endsection

@section('scripts')
{!! $dataTable->scripts() !!}
@endsection
