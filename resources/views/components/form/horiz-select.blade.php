<div class="form-group">
    {{ Form::label($name, null, ['class' => "col-sm-3 control-label"]) }}
    <div class="col-sm-9">
        {{ Form::select($name, $values, $selected, ['class' => 'form-control']) }}
        <span class="help-block text-red">{{$errors->first($name)}}</span>
    </div>
</div>