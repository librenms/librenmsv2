@extends('layouts.app')

@include('includes.datatables')

@section('title', 'Alerts')

@section('content')
{!! $dataTable->table(['class' => 'table table-hover']) !!}
@endsection

@section('scripts')
    {!! $dataTable->scripts() !!}
    <script src="{{ url('js/core/alerting.js') }}"></script>
@endsection
