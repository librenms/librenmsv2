{!! Form::open(['route' => ['users.store'], 'class'=>'userForm form-horizontal']) !!}
<div class="row">
    <div class="col-md-6">
        {{ Form::bsText('realname', isset($user) ? $user->realname : '') }}
        {{ Form::bsText('username', isset($user) ? $user->username : '') }}
        {{ Form::bsText('email', isset($user) ? $user->email : '') }}
        {{ Form::bsText('descr', isset($user) ? $user->descr : '') }}
    </div>
    <div class="col-md-6">
        {{ Form::bsSelect('level', ['1' => trans('user.level.1'), '5' => trans('user.level.5'), '10' => trans('user.level.10')]) }}
        {{ Form::bsPassword('password') }}
        {{ Form::bsPassword('password_confirmation') }}
    </div>
</div>
{{ Form::bsSubmit('Save', 'btn-primary modalFooterContent saveUser')}}
{!! Form::close() !!}