<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalDeleteTitle">
                    @if(isset($title))
                        {{ $title }}
                    @else
                        {{ trans('general.text.delete.title') }}
                    @endif
                </h4>
            </div>
            <div class="modal-body">
                <div class="text-center" id="modalDeleteContent">
                    @if(isset($message))
                        {{ $message }}
                    @else
                        {{ trans('general.text.delete.confirm') }}
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                {!! Form::open(['id' => 'modalDeleteForm', 'method' => 'DELETE']) !!}
                {!! Form::submit('Delete', ['class' => 'btn btn-danger modalDeleteConfirm']) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('button.cancel') }}</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
