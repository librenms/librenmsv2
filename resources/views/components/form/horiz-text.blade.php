<div class="form-group">
    {{ Form::label($name, isset($attributes['label']) ? $attributes['label'] : null, ['class' => "col-sm-3 control-label"]) }}
    <div class="col-sm-9">
        {{ Form::text($name, $value, \App\Util::arrayMergeConcat(['class' => 'form-control '], $attributes)) }}
        <span class="help-block text-red">{{$errors->first($name)}}</span>
    </div>
</div>
