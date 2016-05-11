@extends('layouts.app')

@include('includes.datatables')

@section('title', trans('nav.settings.users'))

@section('content-header')
    <h1>
        {{ trans('nav.settings.users') }}
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> {{ trans('nav.home') }}</a></li>
        <li class="active">{{ trans('nav.settings.users') }}</li>
    </ol>
@endsection

@section('content')
    <div style="margin-bottom: 15px">
    <button type="button" class="btn btn-primary showModal" data-href="{{ route('users.create') }}" data-toggle="modal"
            data-target="#generalModal" data-modal-title="{{ trans('user.manage.create') }}">
        <i class="fa fa-user-plus"></i> {{ trans('user.manage.create') }}
    </button>
    </div>
    <div class="container">
    {!! $dataTable->table(['class' => 'table table-hover']) !!}
        <!-- Modals -->
    @include('components/modals/general')
    @include('components/modals/delete', trans('user.manage.deleteconfirm'))])
    </div>
@endsection

@section('scripts')
    {!! $dataTable->scripts() !!}
    @include('includes.modal')
    <script type="text/javascript">
        $(document).on('click', '.saveUser', function(e){
            e.preventDefault();

            var $this = $(this);
            var form = $('.userForm');
            var table = window.LaravelDataTables["dataTableBuilder"];

            $.ajax({
                url: 	form.attr('action'),
                type: 	form.attr('method'),
                data: 	form.serialize(),
                cache: 	false,
                dataType: 'json',
                success:function(data) {
                    table.ajax.reload();
                    $('#generalModal').modal('hide');
                    toastr.success(data.message);
                },
                error:function(data){
                    var errors = $.parseJSON(data.responseText);
                    form.find('.help-block').empty();
                    $.each(errors, function(field, text) {
                        $('input[name ="'+field+'"]').parent().find('.help-block').text(text);
                    });
                }
            });

            return false;
        });

        $(document).on('click', '.userDeleteModal', function(){
            // copy the action from this button to the form
            $("#modalDeleteForm").prop('action', $(this).attr('data-href'));
        });

        $(document).on('click', '.modalDeleteConfirm', function(e){
            e.preventDefault();

            var $this = $(this);
            var action = $('#modalDeleteForm').attr('action');
            var table = window.LaravelDataTables["dataTableBuilder"];

            $.ajax({
                url: 	action,
                type: 	'delete',
                cache: 	false,
                dataType: 'json',
                success:function(data) {
                    table.ajax.reload();
                    $('#deleteModal').modal('hide');
                    toastr.success(data.message);
                },
                error:function(data) {
                    toastr.error('{{ trans('user.manage.deletefailed') }}')
                }
            });

            return false;
        });
    </script>
@endsection