<div class="form-group">
    {{ Form::label($name, null, array_merge(['class' => "$label_class control-label"])) }}
    <div class="col-sm-9">
        {{ Form::password($name, array_merge(['class' => "$class form-control"], $attributes)) }}
        <p class="text-red form-error"><small>{{$errors->first($name)}}</small></p>
    </div>
</div>
