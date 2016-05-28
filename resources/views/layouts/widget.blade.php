@if ($action == 'settings')

    {!! Form::open(array('action' => null, 'class' => 'form-horizontal widget-settings')) !!}

    @yield('settings')

    <div class="form-group">
        {{ Form::submit(trans('widgets.btn.update_widget'), ['class' => 'btn btn-primary update-widget-settings']) }}
        {{ Form::submit(trans('button.cancel'), ['class' => 'btn btn-danger cancel-widget-settings']) }}
    </div>
    {!! Form::close() !!}
@else
    @yield('content')
@endif

@yield('scripts')
