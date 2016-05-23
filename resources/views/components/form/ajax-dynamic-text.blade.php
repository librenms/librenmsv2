<div class="ajax-form-dynamic">
@foreach($values as $key => $value)
<div class="form-group">

@if($key > 0)
    <div class="col-sm-offset-3 col-sm-9">
@else
    {{ Form::label($name, isset($attributes['label']) ? $attributes['label'] : null, ['class' => "col-sm-3 control-label"]) }}
    <div class="col-sm-9">
@endif

        <div class="input-group">
            {{ Form::text($name, $value, \App\Util::array_merge_concat(['class' => 'form-control ', 'data-index' => $key], $attributes)) }}
            {{--<input type="text" class="form-control" name="{{ $setting }}" data-index="{{ $key }}"--}}
                   {{--data-index="0" data-original-value="{{ $value }}" value="{{ $value }}"--}}
                    {{--{{ Settings::isReadOnly($setting.'.'.$key) ? 'disabled' : '' }} />--}}
        @if($key > 0)
            <span class="input-group-btn"><button type="button" class="btn btn-danger"><i class="fa fa-lg fa-times-circle"></i></button></span>
        @else
            <span class="input-group-btn"><button type="button" class="btn btn-success"><i class="fa fa-lg fa-plus-circle"></i></button></span>
        @endif
        </div>
        <span class="help-block text-red">{{$errors->first($name)}}</span>
    </div>
</div>
@endforeach
</div>
