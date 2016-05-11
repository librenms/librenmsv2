<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="deleteUserLabel">Delete User?</h4>
            </div>
            <div class="modal-body">
                <h4 class="text-center">{{ $user->usernmae }}</h4>
            </div>
            <div class="modal-footer">
                {!! Form::open(['action' => ['UserController@destroy', $user->user_id]]) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                {!! Form::submit('Delete', []) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>