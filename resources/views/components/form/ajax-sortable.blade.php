<div class="form-group">
    <label for="{{ $setting }}" class="col-sm-3 control-label">{{ $label }}</label>
    <div class="col-sm-3">
        <ul id="{{ $setting }}" class="list-group sortable {{ Settings::isReadOnly($setting) ? 'readonly' : '' }}" style="margin-bottom:0;">
            @foreach(Settings::get($setting, $default) as $item )
                <li class="list-group-item" data-value="{{ $item }}"><span class="drag-handle fa fa-bars"></span> {{ $item }}</li>
            @endforeach
        </ul>
        <span class="help-block text-red">{{$errors->first($setting)}}</span>
    </div>
</div>