<div
@if(Settings::isReadOnly($setting))
    class="form-group tooltip-disabled" data-toggle="tooltip" data-title="Read Only: remove from config.php to edit.">
@else
    class="form-group">
@endif
    <label for="{{ $setting }}" class="col-sm-3 control-label">{{ $label }}</label>
    <div class="col-sm-3">
        <ul id="{{ $setting }}" class="list-group sortable {{ Settings::isReadOnly($setting) ? 'readonly' : '' }}" style="margin-bottom:0;">
            @foreach(Settings::get($setting, $default) as $item )
                <li class="list-group-item" data-value="{{ $item }}"><span class="drag-handle fa fa-bars"></span> {{ $item }}</li>
            @endforeach
        </ul>
    </div>
</div>