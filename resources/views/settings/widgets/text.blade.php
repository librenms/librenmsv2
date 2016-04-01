<div
@if(Settings::isReadOnly($setting))
    class="form-group tooltip-disabled" data-toggle="tooltip" data-title="Read Only: remove from config.php to edit.">
@else
    class="form-group">
@endif

        <label for="{{ $setting }}" class="col-sm-3 control-label">{{ $label }}</label>
        <div class="col-sm-9">
            <input type="text" class="form-control ajax-form-simple {{ Settings::isReadOnly($setting) ? 'disabled' : '' }}" id="{{ $setting }}" data-original-value="{{ Settings::get($setting) }}"
                   value="{{ Settings::get($setting) }}" {{ Settings::isReadOnly($setting) ? 'disabled' : '' }}>
        </div>
    </div>