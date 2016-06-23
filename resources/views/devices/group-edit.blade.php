@if (isset($group))
    {!! Form::model($group, ['route' => ['device-groups.update', $group->id], 'method' => 'PUT', 'class' => 'form-horizontal groupForm']) !!}
@else
    {!! Form::open(['route' => ['device-groups.store'], 'method' => 'POST', 'class' => 'form-horizontal groupForm']) !!}
@endif

{{ Form::bsText('name') }}
{{ Form::bsText('desc', null, ['label' => trans('devices.groups.desc')]) }}

<div class="form-group">
    <div class="col-sm-12">
        <div class="row">
            <label for="pattern" class="col-sm-3 control-label">Pattern</label>
            <div class="col-sm-9"><span class="help-block text-red">{{$errors->first('pattern')}}</span></div>
        </div>
        <div class="row">
            <div id="pattern" class="col-sm-12"></div>
        </div>
    </div>
</div>

{{ Form::bsSubmit('Save', ['class' => 'btn-primary modalFooterContent', 'id' => 'btn-save'])}}
{!! Form::close() !!}

<script type="text/javascript">
    var builder = $('#pattern');
    builder.queryBuilder({
        plugins: {
            'bt-tooltip-errors': null
        },
        filters: {!! \App\QueryBuilderFilter::getGroupFilter() !!}
    });

    @if(isset($group))
            try {
        builder.queryBuilder('setRulesFromSQL', "{!! $group->pattern !!}");
    } catch (err) {
        console.log(err);
        toastr.error('{{ trans('devices.groups.ruleloadfailed') }}');
    }
    @endif

    $('#btn-save').on('click', function (e) {
        var result = $('#pattern').queryBuilder('getSQL');

        e.preventDefault();

        var form = $('.groupForm');

        var data = form.serializeArray();
        data.push({name: "pattern", value: result.sql});

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: data,
            cache: false,
            dataType: 'json',
            success: function (data) {
                LaravelDataTables['dataTableBuilder'].draw(false);
                $('#generalModal').modal('hide');
                toastr.success(data.message);
            },
            error: function (data) {
                console.log(data);
                if (data.responseText) {
                    var errors = $.parseJSON(data.responseText);
                    form.find('.help-block').empty();
                    $.each(errors, function (field, text) {
                        $('input[name ="' + field + '"]').parent().find('.help-block').text(text);
                    });
                } else {
                    toastr.error(data.statusText);
                }
            }
        });

        return false;

    });

    // use select2 for filter select
    setTimeout(function () { // work around odd race condition
        builder.find('.rule-filter-container>select').select2();
    }, 100);
    builder.on('afterCreateRuleFilters.queryBuilder', function (e, rule) {
        rule.$el.find('select').select2();
    });

</script>
