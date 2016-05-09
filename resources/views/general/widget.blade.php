@extends('layouts.widget')

@include('includes.datatables')

@section('content')
{!! $dataTable->table() !!}
@endsection

@section('scripts')
{!! $dataTable->scripts() !!}
<script src="{{ url('js/core/alerting.js') }}"></script>
@endsection
