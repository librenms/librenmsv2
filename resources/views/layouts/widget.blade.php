
@if ($action == 'settings')

    {!! Form::open(array('method' => 'post', 'id' => 'widget-settings', 'class' => 'form-horizontal')) !!}

    @yield('settings')

    <div class="form-group">
        {{ Form::submit(trans('widgets.btn.update_widget'), ['class' => 'btn btn-primary', 'id' => 'update-widget-settings']) }}
        {{ Form::submit(trans('button.cancel'), ['class' => 'btn btn-danger', 'id' => 'cancel-widget-settings']) }}
    </div>
    {!! Form::close() !!}

@else
    @yield('content')
@endif


@yield('scripts')
