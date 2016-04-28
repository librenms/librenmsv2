@extends('layouts.app')

@section('title', trans('nav.overview.tools.rirtools'))

@section('content-header')
    <h1>
        {{ trans('nav.overview.tools.rirtools') }}
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> {{ trans('nav.home') }}</a></li>
        <li><a href="{{ url('/tools') }}">{{ trans('nav.overview.tools.main') }}</a></li>
        <li class="active">{{ trans('nav.overview.tools.rirtools') }}</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        {!! Form::open(array('url' => '', 'method' => 'post')) !!}
            <div class="form-group">
                {{ Form::label('name', trans('general.text.lookup')) }}
            </div>
            <div class="radio">
                <label>{{ Form::radio('query-type', 'abuse-contact-finder', true) }}{{ trans('general.text.abuse-contact') }}</label>
            </div>
            <div class="radio">
                <label>{{ Form::radio('query-type', 'whois', false) }}{{ trans('general.text.whois') }}</label>
            </div>
            <div class="form-group">
                {{ Form::label('query', trans('general.text.query')) }}
            </div>
            <div class="input-group">
                {{ Form::text('query', '', ['class' => 'form-control', 'placeholder' => 'IP, ASN, etc']) }}
                <span class="input-group-btn">
                    {{ Form::submit(trans('general.btn.query'), ['class' => 'btn btn-primary', 'name' => 'rir-submit', 'id' => 'rir-submit']) }}
                </span>
            </div>
        {!! Form::close() !!}
    </div>
    <div class="col-md-8">
        <div class="box box-solid">
            <div class="box-header with-border">
                <i class="fa fa-align-justify"></i>
                <h3 class="box-title">Output:</h3>
            </div>
            <div class="box-body">
                <ul id="rir-output">
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $('#rir-submit').click('', function(event) {
            event.preventDefault();
            $('#rir-output').append('<p class="text-center"><i class="fa fa-cog fa-spin fa-5x fa-fw margin-bottom"></i>');
            $('#rir-output').append('<span class="sr-only">Loading...</span></p>');
            var query_type  = $("input[type='radio'][name='query-type']:checked").val();
            var query = $("#query").val();
            if (query_type == "") {
                toastr.error('{{ trans('general.text.nolookuptype') }}')
            }
            if (query == "") {
                toastr.error('{{ trans('general.text.noquery') }}');
            }
            if (query_type != "" && query != "") {
                $.ajax({
                    type: 'GET',
                    url: 'https://stat.ripe.net/data/'+query_type+'/data.json?resource='+query,
                    'dataType': 'jsonp',
                    success: function(output) {
                        $('#rir-output').empty();
                        console.log(output.data.records);
                        if (output.data.records)
                            $.each(output.data.records[0], function(row, value) {
                                $('#rir-output').append('<li>'+value['key'] + ' = ' + value['value'] + '</li>');
                            });
                        else if (output.data.anti_abuse_contacts.abuse_c)
                            $.each(output.data.anti_abuse_contacts.abuse_c, function(row, value) {
                                $('#rir-output').append('<li>'+value['description'] + ' = ' + value['email'] + '</li>');
                            });
                    },
                    error: function() {
                        toastr.error('{{ trans('general.text.apierror') }}');
                    }
                });
            }
        });
    </script>
@endsection
