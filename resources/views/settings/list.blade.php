@extends('layouts.app')

@section('title', trans('nav.settings.global'))

@section('content-header')
    <h1>
        {{ trans('nav.settings.global') }}
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> {{ trans('nav.home') }}</a></li>
        @if( isset($section) )
            <li><a href="{{ url('/settings') }}">{{ trans('nav.settings.main') }}</a></li>
            <li class="active">{{ ucfirst($section) }}</li>
        @else
            <li class="active">{{ trans('nav.settings.main') }}</li>
        @endif
    </ol>
@endsection


@section('content')
<div class="container">
    @if( isset($section) )
        <div class="row">
            @include('settings.sections.' . $section)
        </div>
    @else
        <!-- include all sections, two per row -->
        <div class="row">
            @include('settings.sections.snmp')
        </div>

        <div class="row">
            <div class="box col-lg-6">
                <div class="box-header">
                    <h3 class="box-title">All Settings</h3>
                </div>
                <div class="box-body">
            <pre>
{{ print_r(Settings::all(), 1) }}
            </pre>
                </div>
            </div>
        </div>
</div>
    @endif


@endsection

@section('js_before_bootstrap')
    <script src="{{ url('js/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
@endsection

@section('scripts')
    <script src="{{ url('js/util.js') }}"></script>
    <script type="application/javascript">
        $.Util.ajaxSetup();

        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });

        $('.sortable').sortable({
            handle: '.drag-handle',
            create: function () {
                var $this = $(this);
                if($this.hasClass('readonly')) {
                    $this.sortable('disable');
                    $('span.drag-handle',this ).remove();
                }
            },
            update: function () {
                var $this = $(this);
                // Disabling sorting
                $this.sortable('disable');
                // Adding effect
                $this.addClass('pulsate');

                var key = $this.attr('id');
                var data = $this.sortable('toArray', {attribute: 'data-value'});

                $.ajax({
                    type: 'POST',
                    url: '{{ url('settings') }}',
                    data: {
                        type: 'settings-array',
                        key: key,
                        value: data
                    },
                    dataType: 'html',
                    success: function () {
                        $this.sortable('enable');
                        $this.removeClass('pulsate');

                        $this.closest('.form-group').addClass('has-success');
                        setTimeout(function () {
                            $this.closest('.form-group').removeClass('has-success');
                        }, 2000);
                    },
                    error: function () {
                        $this.sortable('cancel');
                        $this.sortable('enable');
                        $this.removeClass('pulsate');

                        $this.closest('.form-group').addClass('has-error');
                        setTimeout(function () {
                            $this.closest('.form-group').removeClass('has-error');
                        }, 2000);
                    }
                });
            }
        });

        $('.ajax-form-simple').bind('blur keyup', function(e) {
            if(e.type === 'keyup' && e.keyCode !== 13) return;
            var $this = $(this);
            var data = $this.val();

            var original = $this.data('original-value');
            if(data == original) return;

            var key = $this.attr('id');

            $this.after('<i class="fa fa-spin fa-spinner fa-lg"></i>');

            $.ajax({
                type: 'POST',
                url: '{{ url('settings') }}',
                data: {
                    type: 'settings-value',
                    key: key,
                    value: data
                },
                dataType: 'html',
                success: function () {
                    $this.data('original-value', data);
                    $this.closest('.form-group').addClass('has-success');
                    $this.next('i').remove();
                    $this.after('<i class="fa fa-check fa-lg"></i>');
                    setTimeout(function () {
                        $this.closest('.form-group').removeClass('has-success');
                        $this.next('i').remove();
                    }, 2000);
                },
                error: function () {
                    $this.val(original);
                    $this.closest('.form-group').addClass('has-error');
                    $this.next('i').remove();
                    $this.after('<i class="fa fa-close fa-lg"></i>');
                    setTimeout(function () {
                        $this.closest('.form-group').removeClass('has-error');
                        $this.next('i').remove();
                    }, 2000);
                }
            });
        });

        $('.ajax-form-radio').change(function() {
            var $this = $(this);
            var key = $this.attr('name');
            var data = $this.data('value');

            $this.closest('label').after('<i class="fa fa-spin fa-spinner fa-lg"></i>');

            $.ajax({
                type: 'POST',
                url: '{{ url('settings') }}',
                data: {
                    type: 'settings-value',
                    key: key,
                    value: data
                },
                dataType: 'html',
                success: function () {
                    $this.parent().siblings('.current').removeClass('current');
                    $this.parent().addClass('current');
                    $this.closest('label').next('i').remove();

                    $this.closest('.form-group').addClass('has-success');
                    setTimeout(function () {
                        $this.closest('.form-group').removeClass('has-success');
                    }, 2000);
                },
                error: function () {
                    $this.parent().removeClass('active');
                    $this.parent().siblings('.current').addClass('active');
                    $this.closest('label').next('i').remove();

                    $this.closest('.form-group').addClass('has-error');
                    setTimeout(function () {
                        $this.closest('.form-group').removeClass('has-error');
                    }, 2000);
                }
            });
        });


    </script>
@endsection


