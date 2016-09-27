@if(isset($user))
    {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'PUT', 'class' => 'form-horizontal modalForm']) !!}
@else
    {!! Form::open(['route' => ['users.store'], 'method' => 'POST', 'class' => 'form-horizontal modalForm']) !!}
@endif

<div class="row">
    <div class="col-md-6">
        {{ Form::bsText('realname', isset($user) ? $user->realname : '') }}
        {{ Form::bsText('username', isset($user) ? $user->username : '') }}
        {{ Form::bsText('email', isset($user) ? $user->email : '') }}
        {{ Form::bsText('descr', isset($user) ? $user->descr : '', ['label' => trans('user.text.descr')]) }}
    </div>
    <div class="col-md-6">
        {{ Form::bsSelect('level', ['1' => trans('user.level.1'), '5' => trans('user.level.5'), '10' => trans('user.level.10')]) }}
        {{ Form::bsPassword('password') }}
        {{ Form::bsPassword('password_confirmation') }}
    </div>
</div>
{{ Form::bsSubmit('Save', ['class' => 'btn-primary modalFooterContent modalSave'])}}
{!! Form::close() !!}