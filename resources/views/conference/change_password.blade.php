@extends('layouts.partials.content')

@section('inner-content')
    <div class="panel-heading">{{ trans('static.change-password') }}</div>
    <div class="panel-body">
        @include('layouts.partials.messages.errors')
        {!! Form::open(['method' => 'put', 'url' => route('department::user::change', [$department->keyword])]) !!}
            <div class="col-md text-center">
                <label>{{ trans('static.change-password-title') }}</label>
            </div>
            <div class="form-group">
                <label for="inputPassword">{{ trans('static.current-password') }}</label>
                <input name="password" type="password" class="form-control" id="inputPassword" placeholder="{{ trans('static.current-password') }}">
            </div>
            <div class="form-group">
                <label for="inputNewPassword">{{ trans('static.new-password') }}</label>
                <input name="newPassword" type="password" class="form-control" id="inputNewPassword" placeholder="{{ trans('static.new-password') }}">
            </div>
            <div class="form-group">
                <label for="inputNewPasswordConfirm">{{ trans('static.new-password-confirm') }}</label>
                <input name="newPasswordConfirm" type="password" class="form-control" id="inputNewPasswordConfirm" placeholder="{{ trans('static.new-password-confirm') }}">
            </div>
            @include('layouts.partials.button', ['button' => trans('static.save') ])
        {!! Form::close() !!}
    </div>
@endsection