@extends('layouts.widget')

@include('includes.datatables')

@section('content')
{!! $dataTable->table($tableName) !!}
@endsection

@section('scripts')
{!! $dataTable->scripts() !!}
@endsection
