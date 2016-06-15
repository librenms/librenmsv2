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

    {!! $dataTable->table(['class' => 'table table-hover']) !!}

    <!-- Modals -->
    @include('components/modals/general')
    @include('components/modals/delete', trans('user.manage.deleteconfirm'))
@endsection

@section('scripts')
    {!! $dataTable->scripts() !!}
    @include('includes.modal')
    <script type="text/javascript">

        $(document).on('click', '.userDeleteModal', function () {
            // copy the action from this button to the form
            $("#modalDeleteForm").prop('action', $(this).attr('data-href'));
        });

        $(document).on('click', '.modalDeleteConfirm', function (e) {
            e.preventDefault();

            $.ajax({
                url: $('#modalDeleteForm').attr('action'),
                type: 'delete',
                cache: false,
                dataType: 'json',
                success: function (data) {
                    LaravelDataTables['dataTableBuilder'].draw(false);
                    $('#deleteModal').modal('hide');
                    toastr.success(data.message);
                },
                error: function (data) {
                    toastr.error('{{ trans('user.manage.deletefailed') }}')
                }
            });

            return false;
        });
    </script>
@endsection
