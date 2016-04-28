@extends('layouts.app')

@include('includes.datatables')

@section('title', 'Search')

@section('content')
{!! $dataTable->table(['class' => 'table table-hover']) !!}
@endsection

@section('scripts')
{!! $dataTable->scripts() !!}
@endsection
