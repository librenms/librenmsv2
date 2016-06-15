@extends('layouts.app')

@include('includes.datatables')

@section('title', trans('nav.devices.main'))

@section('content-header')
    <h1>
        {{ trans('nav.devices.groups') }}
        <small>{{ trans('general.text.all') }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> {{ trans('nav.home') }}</a></li>
        <li class="active">{{ trans('nav.devices.groups') }}</li>
    </ol>
@endsection

@section('content')
    <div style="margin-bottom: 15px">
        <button type="button" class="btn btn-primary showModal" data-href="{{ route('device-groups.create') }}" data-toggle="modal"
                data-target="#generalModal" data-modal-title="{{ trans('devices.groups.create') }}">
            <i class="fa fa-plus"></i> {{ trans('devices.groups.create') }}
        </button>
    </div>

    {!! $dataTable->table() !!}
    @include('components.modals.general')
    @include('components.modals.delete', trans('devices.groups.deleteconfirm'))
@endsection

@section('scripts')
    {!! $dataTable->scripts() !!}
    <script src="{{ url('js/core/modals.js') }}"></script>
@endsection
