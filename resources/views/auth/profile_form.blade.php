<div class="form-group">
    <label for="inputEmail">{{ trans('static.email') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
    {!! Form::text('email', null, ['type' => 'email', 'class' => 'form-control', 'id' => 'inputEmail', 'placeholder' => trans('static.email')]) !!}
</div>
<div class="form-group">
    <label for="inputEmail2">{{ trans('static.email2') }}</label>
    {!! Form::text('email2', null, ['type' => 'email', 'class' => 'form-control', 'id' => 'inputEmail2', 'placeholder' => trans('static.email2')]) !!}
</div>
<div class="form-group">
    <label for="inputPassword">{{ trans('static.password') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
    <input name="password" type="password" class="form-control" id="inputPassword" placeholder="{{ trans('static.password') }}">
</div>
<div class="form-group">
    <label for="inputPasswordConfirm">{{ trans('static.password-confirm') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
    <input name="password_confirmation" type="password" class="form-control" id="inputPasswordConfirm" placeholder="{{ trans('static.password-confirm') }}">
</div>