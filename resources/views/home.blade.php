@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-sm-4">
        <form class="form-inline">
            <div class="form-group">
                <select class="form-control" id="dashboard_id" name="dashboard_id" onchange="location = this.options[this.selectedIndex].value;">
                    @foreach ($dashboards as $dashboard)
                        <option value="{{ url('dashboard/'.$dashboard->dashboard_id) }}" @if ($dashboard->dashboard_id == $request->route('dashboard_id')) {{ 'selected' }} @endif >{{ $dashboard->dashboard_name }} @if ($dashboard->access == 1) {{ '- '.trans('dashboard.select.read') }} @elseif ($dashboard->access == 2) {{ '- '.trans('dashboard.select.write') }} @endif</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <a href="#" data-toggle="control-sidebar" class="btn btn-primary"><i class="fa fa-gears"></i></a>
            </div>
        </form>
    </div>
</div><div class="row">
    <div class="col-sm-12">
        <h3 class="box-title">{{ $dash_details->dashboard_name }}</h3>
    </div>
</div>
<div class="row">
    <div class="grid-stack">
    </div>
</div>

@endsection

@section('settings-menu')
<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li class="tab-pane active"><a href="#control-sidebar-add-tab" data-toggle="tab"><i class="fa fa-plus"></i></a></li>
        <li><a href="#control-sidebar-edit-tab" data-toggle="tab"><i class="fa fa-pencil"></i></a></li>
        <li><a href="#control-sidebar-delete-tab" data-toggle="tab"><i class="fa fa-trash"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active" id="control-sidebar-add-tab">
            <div class="row">
                <div class="col-sm-12">
                    {!! Form::open(array('method' => 'post', 'id' => 'confirm-add-dashboard')) !!}
                        <div class="form-group">
                            {{ Form::label('name', trans('dashboard.label.name')) }}
                            {{ Form::text('name', '', array('class' => 'form-control')) }}
                            <div class="text-red form-error"><small></small></div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('access', trans('dashboard.label.sharing')) }}
                            {{ Form::select('access', array('0' => 'Private', '1' => trans('dashboard.select.read'), '2' => trans('dashboard.select.write')), 0, array('class' => 'form-control')) }}
                            <div class="text-red form-error"><small></small></div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('copy_from', trans('dashboard.label.copy')) }}
                            <select class="form-control" id="copy_from" name="copy_from">
                                <option></option>
                                @foreach ($dashboards as $dashboard)
                                    <option value="{{ $dashboard->dashboard_id }}">{{ $dashboard->dashboard_name }} @if ($dashboard->access == 1) {{ '- '.trans('dashboard.select.read') }} @elseif ($dashboard->access == 2) {{ '- '.trans('dashboard.select.write') }} @endif</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            {{ Form::submit(trans('dashboard.btn.create'), ['class' => 'btn btn-primary']) }}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="tab-pane" id="control-sidebar-edit-tab">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        {{ Form::label('name', trans('dashboard.label.add_widget')) }}
                        <select class="form-control" id="widget_id" name="widget_id" data-dashboard_id="{{ $request->route('dashboard_id') }}">
                                <option value=""></option>
                            @foreach ($widgets as $widget)
                                <option value="{{ $widget->widget_id }},{{ $widget->base_dimensions }},{{ $widget->widget_title }}">{{ $widget->widget_title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
                    {!! Form::open(array('method' => 'post')) !!}
                        <div class="form-group">
                            {{ Form::button(trans('dashboard.btn.clear'), ['class' => 'btn btn-danger', 'id' => 'clear-dashboard', 'data-id' => $request->route('dashboard_id')]) }}
                        </div>
                    {!! Form::close() !!}
                    {!! Form::open(array('method' => 'post', 'id' => 'confirm-edit-dashboard', 'data-dashboard_id' => $dash_details->dashboard_id)) !!}
                        <div class="form-group">
                            {{ Form::label('name', trans('dashboard.label.name')) }}
                            {{ Form::text('name', "$dash_details->dashboard_name", array('class' => 'form-control')) }}
                            <div class="text-red form-error"><small></small></div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('access', trans('dashboard.label.sharing')) }}
                            {{ Form::select('access', array('0' => 'Private', '1' => trans('dashboard.select.read'), '2' => trans('dashboard.select.write')), $dash_details->access, array('class' => 'form-control')) }}
                            <div class="text-red form-error"><small></small></div>
                        </div>
                        <div class="form-group">
                            {{ Form::submit(trans('dashboard.btn.update'), ['class' => 'btn btn-primary']) }}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="tab-pane" id="control-sidebar-delete-tab">
            <div class="row">
                {!! Form::open(array('method' => 'post')) !!}
                    <div class="col-sm-6">
                        <div class="form-group">
                            {{ Form::button(trans('dashboard.btn.clear'), ['class' => 'btn btn-danger', 'id' => 'clear-dashboard-2', 'data-id' => $request->route('dashboard_id')]) }}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {{ Form::button(trans('dashboard.btn.delete'), ['class' => 'btn btn-danger', 'id' => 'confirm-delete-dashboard', 'data-id' => $request->route('dashboard_id')]) }}
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
      </div>
    </aside>
<div class="control-sidebar-bg"></div>
@endsection

@section('scripts')
    <script src="{{ url('js/util.js') }}"></script>
    <script src="{{ url('js/core/dashboard.js') }}"></script>
    <script>
        grid = $.Dashboard.setupDashboard();
        grid.removeAll();
        @foreach ($dash_widgets as $dash_widget)
            var data = {!! $dash_widget !!}
            $.Dashboard.addWidget(grid, data, '{{ $token }}');
            $.Dashboard.refreshDashboardWidget('{{ $token }}', data,true);
        @endforeach
        $('.grid-stack').on('dragstop', function(event, ui) {
            setTimeout(function() {
                $.Dashboard.updateWidget(event.target, '{{ $token }}');
            }, 1);
        });
        $('.grid-stack').on('resizestop', function(event, ui) {
            setTimeout(function() {
                $.Dashboard.updateWidget(event.target, '{{ $token }}');
            }, 1);
        });
        $.Dashboard.dashboardActions('{{ $token }}', grid);
    </script>
@endsection
