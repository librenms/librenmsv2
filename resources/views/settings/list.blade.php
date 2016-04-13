@extends('layouts.app')

@section('title', 'Settings')

@section('content')

    @if( isset($section) )
        @include('settings.sections.' . $section)
    @else
        @include('settings.sections.snmp')

        <div class="container">
        <pre>
{{ print_r($settings, 1) }}
        </pre>
        </div>

    @endif


@endsection


@section('scripts')
    <script src="http://rubaxa.github.io/Sortable/Sortable.min.js"></script>
    <script src="{{ url('js/util.js') }}"></script>
    <script type="application/javascript">
        $.Util.ajaxSetup();

        Sortable.create(document.getElementById("snmp.transports"), {
            handle: '.drag-handle',
            animation: 150,
            onStart: function () {
                // Save order before sort
                this._currentOrder = this.toArray();

            },
            onUpdate: function () {
                var sort = this;
                // Disabling sorting
                sort.option('disabled', true);

                var list = $(this.el);
                var key = list.attr('id');
                var sel = "#" + key.replace(/(\.)/g, "\\$1") + " li";

                var data = $(sel).map(function() {
                    return $(this).data("value");
                }).get();

                // Adding effect
                list.addClass('pulsate');

                $.ajax({
                    type: 'POST',
                    url: '{{ url('settings') }}',
                    data: {
                        type: "settings-array",
                        key: key,
                        value: data
                    },
                    dataType: "html",
                    success: function (data) {
                        sort.option('disabled', false);
                        list.removeClass('pulsate');
                    },
                    error: function () {
                        sort.option('disabled', false);
                        list.removeClass('pulsate');
                        sort.sort(sort._currentOrder);

                        list.closest('.form-group').addClass('has-error');
                        setTimeout(function () {
                            list.closest('.form-group').removeClass('has-error');
                        }, 2000);
                    }
                });
            }
        });

        $(".ajax-form-simple").blur(function () {
            var $this = $(this);
            var key = $this.attr('id');
            var data = $this.val();

            $.ajax({
                type: 'POST',
                url: '{{ url('settings') }}',
                data: {
                    type: "settings-value",
                    key: key,
                    value: data
                },
                dataType: "html",
                success: function (data) {
                    $this.closest('.form-group').addClass('has-success');
                    $this.after('<i class="fa fa-check fa-lg"></i>');
                    setTimeout(function () {
                        $this.closest('.form-group').removeClass('has-success');
                        $this.next().remove();
                    }, 2000);
                },
                error: function () {
                    $this.closest('.form-group').addClass('has-error');
                    $this.after('<i class="fa fa-close fa-lg"></i>');
                    setTimeout(function () {
                        $this.closest('.form-group').removeClass('has-error');
                        $this.next().remove();
                    }, 2000);
                }
            });
        });

        $(".ajax-form-radio").change(function() {

            var $this = $(this);
            var key = $this.attr('name');
            var data = $this.data('value');

            $.ajax({
                type: 'POST',
                url: '{{ url('settings') }}',
                data: {
                    type: "settings-value",
                    key: key,
                    value: data
                },
                dataType: "html",
                success: function (data) {
                    $this.closest('.form-group').addClass('has-success');
                    setTimeout(function () {
                        $this.closest('.form-group').removeClass('has-success');
                    }, 2000);
                },
                error: function () {
                    $this.closest('.form-group').addClass('has-error');
                    setTimeout(function () {
                        $this.closest('.form-group').removeClass('has-error');
                    }, 2000);
                }
            });
        });


    </script>
@endsection


