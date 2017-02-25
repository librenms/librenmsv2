<button type="button" class="btn btn-xs btn-primary showModal"  data-toggle="modal" data-target="#generalModal" data-href="{{ route('device-groups.edit', ['group_id' => $id]) }} ">
<i class="fa fa-edit fa-lg fa-fw"></i><span class="hidden-xs"> @lang('Edit')</span></button>

<button type="button" class="btn btn-xs btn-danger deleteModal" data-toggle="modal" data-target="#deleteModal" data-href="{{ route('device-groups.destroy', ['group_id' => $id]) }}">
<i class="fa fa-trash fa-lg fa-fw"></i><span class="hidden-xs"> @lang('Delete')</span></button>

