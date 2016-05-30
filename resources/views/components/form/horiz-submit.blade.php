<div class="form-group">
    <div class="col-sm-offset-3 col-sm-9">
        {{ Form::button($name, array_merge(['type' => 'submit'], \App\Util::arrayMergeConcat(['class' => "btn "], $attributes))) }}
    </div>
</div>
