@extends('layouts.app')

@section('title', trans('nav.settings.global'))

@section('content-header')
    <h1>
        {{ trans('nav.settings.global') }}
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> {{ trans('nav.home') }}</a></li>
        @if( isset($section) )
            <li><a href="{{ url('/settings') }}">{{ trans('nav.settings.main') }}</a></li>
            <li class="active">{{ ucfirst($section) }}</li>
        @else
            <li class="active">{{ trans('nav.settings.main') }}</li>
        @endif
    </ol>
@endsection


@section('content')
<div class="container">
    <div class="row">
        <div class="form-horizontal col-sm-12">
            <div class="form-group">
                {{ Form::label('settingsFilter', 'Filter:', ['class' => 'control-label col-sm-9']) }}
                <div class="col-sm-3">
                    {{ Form::input('search', 'settingsFilter', null, ['class' => 'form-control', 'placeholder' => 'Type to filter settings'] ) }}
                </div>
            </div>
        </div>
    </div>
    @if( isset($section) )
        <div class="row">
            <section id="{{ $section }}" class="box col-lg-6 connectedSortable">
                @include('settings.sections.' . $section)
            </section>
        </div>
    @else
        <!-- include all sections, two per row -->
        <div class="row">
            <section id="snmp" class="col-lg-6 connectedSortable">
                @include('settings.sections.snmp')
            </section>
            <section id="empty" class="col-lg-6 connectedSortable">
                <div class="box">
                    Empty
                </div>
            </section>
        </div>

        <div class="row">
            <div class="box col-lg-6 connectedSortable">
                <div class="box-header">
                    <h3 class="box-title">All Settings</h3>
                </div>
                <div class="box-body">
            <pre>
{{ print_r(Settings::all(), 1) }}
            </pre>
                </div>
            </div>
        </div>
    @endif
</div>


@endsection

@section('js_before_bootstrap')
    <script src="{{ url('js/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
@endsection

@section('scripts')
    <script src="{{ url('js/util.js') }}"></script>
    <script type="application/javascript">
        // set the url for ajax calls
        var settings_url = "{{ url('settings') }}";
    </script>
    <script src="{{ url('js/pages/settings.js') }}"></script>
@endsection
