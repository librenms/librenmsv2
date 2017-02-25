<a type="button" class="btn btn-xs btn-primary" href="{{ route('users.edit', ['user_id' => $user_id]) }}">
<i class="fa fa-edit fa-lg fa-fw"></i><span class="hidden-xs"> @lang('Edit')</span></a>

<button type="button" class="btn btn-xs btn-danger deleteModal" data-toggle="modal" data-target="#deleteModal" data-href="{{ route('users.destroy', ['user_id' => $user_id]) }}">
<i class="fa fa-trash fa-lg fa-fw"></i><span class="hidden-xs"> @lang('Delete')</span></button>
